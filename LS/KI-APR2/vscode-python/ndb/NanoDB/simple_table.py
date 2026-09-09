from random import Random
from typing import Any, Iterable, Mapping, Sequence

from nanodb import Column, ColumnType, DataType, Row, Table, Value


class SimpleTable(Table):
    def __init__(self, name: str, column_names: Sequence[str]) -> None:
        columns = [Column("_id", ColumnType(DataType.INT, not_null=True, unique=True))]
        for column_name in column_names:
            columns.append(Column(column_name, ColumnType(DataType.TEXT)))
        super().__init__(name, columns=columns, primary_key=["_id"])
        self._id_generator = Random()

    def insert(self, column_names: Sequence[str], values: Row) -> None:
        raise NotImplementedError("Use add_row instead")

    def add_row(self, *args: Sequence[str]) -> None:
        values: list[Any] = list(args)
        values.insert(0, self._id_generator.randint(0, 1_000_000_000_000))
        names = [column.name for column in self.columns]
        super().insert(column_names=names, values=tuple(values))

    def add_rows(self, *args: Sequence[Sequence[str]]) -> None:
        for row in args:
            self.add_row(*row)

    def iter_rows_as_dict(self) -> Iterable[Mapping[str, Value]]:
        return (self._row_to_mapping(row) for row in self)


if __name__ == "__main__":
    table = SimpleTable("person", ["name", "phone"])
    table.add_row("Petr", "123 456 789")
    table.add_rows(("Jan", "123 456 000"), ("Anna", "123 456 999"))
    print(table.to_text())
    print(list(table.iter_rows_as_dict()))
    print(table.get_column("name"))
