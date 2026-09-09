from collections.abc import Collection, Sequence
from datetime import date
from decimal import Decimal
from enum import Enum
from typing import Callable, Iterator, Mapping, TypeAlias

Value: TypeAlias = None | int | Decimal | str | date
Row: TypeAlias = tuple[Value, ...]


def value_to_text(value: Value) -> str:
    """Convert one database value to its text representation."""
    if value is None:
        return "NULL"
    return str(value)


def row_to_texts(row: Row) -> list[str]:
    """Convert one table row to a list of strings."""
    return [value_to_text(value) for value in row]


def compute_column_widths(
    headers: Sequence[str], rows: Sequence[Sequence[str]]
) -> list[int]:
    """Compute display widths for all columns."""
    widths = [len(header) for header in headers]

    for row in rows:
        for i, value in enumerate(row):
            widths[i] = max(widths[i], len(value))

    return widths


def make_separator(widths: Sequence[int]) -> str:
    """Create a horizontal separator line."""
    parts = ["-" * (width + 2) for width in widths]
    return "+" + "+".join(parts) + "+"


def make_data_line(values: Sequence[str], widths: Sequence[int]) -> str:
    """Create one formatted table line."""
    cells = [f" {value:<{width}} " for value, width in zip(values, widths)]
    return "|" + "|".join(cells) + "|"


class DataType(Enum):
    """Supported database data domains."""

    INT = 0
    DECIMAL = 1
    TEXT = 2
    DATE = 3


class ColumnType:
    """Description of a database column type."""

    def __init__(
        self,
        data_type: DataType,
        not_null: bool = False,
        unique: bool = False,
    ) -> None:
        self.data_type = data_type
        self.not_null = not_null
        self.unique = unique


class Column:
    """Definition of one table column."""

    def __init__(self, name: str, column_type: ColumnType) -> None:
        self.name = name
        self.column_type = column_type


TYPE_INFO: dict[DataType, type] = {
    DataType.INT: int,
    DataType.DECIMAL: Decimal,
    DataType.TEXT: str,
    DataType.DATE: date,
}


def has_duplicates(items: Collection[str]) -> bool:
    """Return True if the collection contains duplicate values."""
    return len(items) != len(set(items))


class Table:
    """
    Simple in-memory relational table.

    Schema:
        - table name
        - ordered sequence of columns
        - primary key (sequence of column names)

    Data:
        - rows stored as tuples
    """

    def __init__(
        self, name: str, columns: Sequence[Column], primary_key: Sequence[str]
    ):
        if not columns:
            raise ValueError("Table must have at least one column.")

        column_names = [column.name for column in columns]
        if has_duplicates(column_names):
            raise ValueError("Column names must be unique.")

        self.name = name
        self._columns = columns
        self._column_map = {column.name: column for column in columns}
        self._column_index = {
            column.name: index for index, column in enumerate(columns)
        }
        self._rows: list[Row] = []

        if not primary_key:
            raise ValueError("Primary key must contain at least one column.")

        if has_duplicates(primary_key):
            raise ValueError("Primary key columns must be unique.")

        for col_name in primary_key:
            if col_name not in self._column_map:
                raise ValueError(f"Unknown primary key column {col_name!r}.")

        self._primary_key = tuple(primary_key)

        if len(self._primary_key) == 1:
            pk_col = self._column_map[self._primary_key[0]]
            if not pk_col.column_type.not_null:
                raise ValueError("Single-column primary key must be NOT NULL.")
            if not pk_col.column_type.unique:
                raise ValueError("Single-column primary key must be UNIQUE.")
        else:
            for col_name in self._primary_key:
                col = self._column_map[col_name]
                if not col.column_type.not_null:
                    raise ValueError(
                        f"Primary key column {col_name!r} must be NOT NULL."
                    )

    @property
    def columns(self) -> Sequence[Column]:
        """Return ordered columns."""
        return tuple(self._columns)

    @property
    def primary_key(self) -> Sequence[str]:
        """Return primary key columns."""
        return self._primary_key

    def __iter__(self) -> Iterator[Row]:
        """Return an iterator over table rows."""
        return iter(self._rows)

    def __len__(self) -> int:
        """Return the number of rows in the table."""
        return len(self._rows)

    def insert(self, column_names: Sequence[str], values: Row) -> None:
        """
        Insert one row into the table.

        Missing columns are filled with None.
        """
        if len(column_names) != len(values):
            raise ValueError("column_names and values must have the same length.")

        if has_duplicates(column_names):
            raise ValueError("Column names in INSERT must be unique.")

        for col_name in column_names:
            if col_name not in self._column_map:
                raise ValueError(f"Unknown column {col_name!r}.")

        value_map = dict(zip(column_names, values))
        row: list[Value] = []

        for column in self._columns:
            value = value_map.get(column.name, None)
            self._validate_value(column, value)
            row.append(value)

        row_tuple: Row = tuple(row)
        self._check_unique_constraints(row_tuple)
        self._check_primary_key_uniqueness(row_tuple)
        self._rows.append(row_tuple)

    @staticmethod
    def _validate_value(column: Column, value: Value) -> None:
        """
        Validate one value against a column definition.

        None represents SQL NULL.
        """
        col_type = column.column_type

        if value is None:
            if col_type.not_null:
                raise ValueError(f"Column {column.name!r} cannot be NULL.")
            return

        expected_type = TYPE_INFO.get(col_type.data_type)
        if expected_type is None:
            raise TypeError(f"Unsupported data type in column {column.name!r}.")

        if not isinstance(value, expected_type):
            raise TypeError(f"Column {column.name!r} expects {expected_type.__name__}.")

    def _check_unique_constraints(self, new_row: Row) -> None:
        """Check UNIQUE constraints for all columns."""
        for column in self._columns:
            if not column.column_type.unique:
                continue

            index = self._column_index[column.name]
            new_value = new_row[index]

            if new_value is None:
                continue

            for row in self._rows:
                if row[index] == new_value:
                    raise ValueError(
                        f"UNIQUE constraint violated for column {column.name!r}."
                    )

    def _check_primary_key_uniqueness(self, new_row: Row) -> None:
        """Check uniqueness of the primary key."""
        pk_indexes = self._indexes_for(self._primary_key)
        new_key = self._extract_key(new_row, pk_indexes)

        if any(value is None for value in new_key):
            raise ValueError("Primary key cannot contain NULL.")

        for row in self._rows:
            if self._extract_key(row, pk_indexes) == new_key:
                raise ValueError("Duplicate primary key.")

    def _indexes_for(self, column_names: Sequence[str]) -> Sequence[int]:
        """Return tuple of column indexes for given column names."""
        return tuple(self._column_index[name] for name in column_names)

    @staticmethod
    def _extract_key(row: Row, indexes: Sequence[int]) -> Row:
        """Extract a key tuple from a row using given indexes."""
        return tuple(row[index] for index in indexes)

    def inner_join(self, other: "Table", other_foreign_key: Sequence[str]) -> "Table":
        """
        Perform an inner join using self.primary_key and other_foreign_key.

        The table `other` is treated as the referencing table:
        its columns in `other_foreign_key` reference `self.primary_key`.

        Rows from `other` with NULL in any foreign-key column are ignored.

        Result schema:
            - name: 'selfname_othername'
            - columns: prefixed as 'table.column'
            - primary key: union of both original primary keys with prefixes
        """
        self._validate_join_columns(other, other_foreign_key)

        result = self._create_join_result_table(other)
        lookup = self._build_primary_key_lookup()
        other_fk_indexes = other._indexes_for(other_foreign_key)

        for other_row in other._rows:
            foreign_key_value = other._extract_key(other_row, other_fk_indexes)

            if not any(value is None for value in foreign_key_value):
                self_row = lookup.get(foreign_key_value)
                if self_row is not None:
                    result._rows.append(self_row + other_row)

        return result

    def to_text(self) -> str:
        """Return the table formatted as an ASCII text table."""
        headers = [column.name for column in self._columns]
        rows_as_text = [row_to_texts(row) for row in self._rows]
        widths = compute_column_widths(headers, rows_as_text)

        separator = make_separator(widths)
        header_line = make_data_line(headers, widths)

        lines = [separator, header_line, separator]
        for row in rows_as_text:
            lines.append(make_data_line(row, widths))
        lines.append(separator)

        return "\n".join(lines)

    def _validate_join_columns(
        self, other: "Table", other_foreign_key: Sequence[str]
    ) -> None:
        """Validate that other_foreign_key correctly references self.primary_key."""
        if len(other_foreign_key) != len(self._primary_key):
            raise ValueError(
                "Foreign key must have the same length as the primary key."
            )

        if has_duplicates(other_foreign_key):
            raise ValueError("Foreign key columns must be unique.")

        for col_name in other_foreign_key:
            if col_name not in other._column_map:
                raise ValueError(f"Unknown foreign key column {col_name!r}.")

        for self_pk_name, other_fk_name in zip(self._primary_key, other_foreign_key):
            self_col = self._column_map[self_pk_name]
            other_col = other._column_map[other_fk_name]

            if self_col.column_type.data_type != other_col.column_type.data_type:
                raise TypeError(
                    f"Type mismatch between {self.name}.{self_pk_name!r} "
                    f"and {other.name}.{other_fk_name!r}."
                )

    def _create_join_result_table(self, other: "Table") -> "Table":
        """Create the empty result table for an inner join."""
        result_name = f"{self.name}_{other.name}"
        result_columns = self._prefixed_columns(self.name) + other._prefixed_columns(
            other.name
        )
        result_primary_key = self._prefixed_primary_key(
            self.name
        ) + other._prefixed_primary_key(other.name)

        return Table(
            name=result_name,
            columns=result_columns,
            primary_key=result_primary_key,
        )

    def _prefixed_columns(self, table_name: str) -> list[Column]:
        """
        Return columns prefixed by table name.
        """
        result: list[Column] = []
        for column in self._columns:
            result.append(
                Column(
                    f"{table_name}.{column.name}",
                    ColumnType(
                        data_type=column.column_type.data_type,
                        not_null=column.column_type.not_null,
                        unique=False,  # UNIQUE is not preserved in join results!
                    ),
                )
            )
        return result

    def _prefixed_primary_key(self, table_name: str) -> list[str]:
        """Return primary-key column names prefixed by table name."""
        return [f"{table_name}.{col_name}" for col_name in self._primary_key]

    def _build_primary_key_lookup(self) -> dict[Row, Row]:
        """Build a hash lookup from primary-key value to row."""
        pk_indexes = self._indexes_for(self._primary_key)
        lookup: dict[Row, Row] = {}

        for row in self._rows:
            key = self._extract_key(row, pk_indexes)
            lookup[key] = row

        return lookup

    def _row_to_mapping(self, row: Row) -> Mapping[str, Value]:
        """Convert one row tuple to a dictionary keyed by column names.
        protected method (used in derived classes)"""
        return {column.name: value for column, value in zip(self._columns, row)}

    def where(self, predicate: Callable[[Mapping[str, Value]], bool]) -> "Table":
        """Return a new table containing only rows satisfying the predicate."""
        result = Table(self.name, self._columns, self._primary_key)

        for row in self._rows:
            if predicate(self._row_to_mapping(row)):
                result._rows.append(row)

        return result

    def select_to(
        self,
        transform: Callable[[Mapping[str, Value]], Mapping[str, Value]],
        target: "Table",
    ) -> "Table":
        """
        Project rows of this table into the target table.

        The function ``transform`` defines how one source row is projected to one
        row of the target table. It receives a mapping from source column names
        to source values and returns a mapping from target column names to target
        values.

        The returned mapping must describe a row compatible with the schema of
        the target table:
        target column names must be valid, returned values must have appropriate
        types, and all constraints of the target table must be satisfied.

        Args:
            transform: Function defining the projection from a source row to a
                target row.
            target: Table representing the schema of the projection result.

        Returns:
            The target table extended by projected rows.
        """
        ...

    def get_column(self, column_name: str) -> Sequence[Value]:
        result: list[Value] = []
        index = self._column_index[column_name]
        for row in self._rows:
            result.append(row[index])
        ...
        return result
