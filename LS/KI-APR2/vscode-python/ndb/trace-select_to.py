from typing import Callable, Mapping

from NanoDB.nanodb import Column, ColumnType, DataType, Table, Value


class MyTable(Table):
    def select_to(
        self,
        transform: Callable[[Mapping[str, Value]], Mapping[str, Value]],
        target: Table,
    ) -> Table:
        for row in self._rows:
            if transformed_mapping := transform(self._row_to_mapping(row)):
                names, values = zip(*transformed_mapping.items())
                target.insert(column_names=names, values=values)
        return target


TableImpl = Table
# TableImpl = MyTable # Uncomment to use the custom select_to implementation

A = TableImpl(
    "A",
    [
        Column("a", ColumnType(DataType.TEXT, not_null=True, unique=True)),
        Column("b", ColumnType(DataType.INT, not_null=True)),
    ],
    primary_key=["a"],
)

B = TableImpl(
    "B",
    [
        Column("name", ColumnType(DataType.TEXT, not_null=True, unique=True)),
        Column("square", ColumnType(DataType.INT, not_null=True)),
    ],
    primary_key=["name"],
)

A.insert(("a", "b"), ("x", 1))
A.insert(("a", "b"), ("z", 3))
A.insert(("a", "b"), ("y", 2))


# Select to B with a transformation
def transform(row: Mapping[str, Value]) -> Mapping[str, Value]:
    assert isinstance(row["a"], str)
    assert isinstance(row["b"], int)
    return {"name": row["a"] * 2, "square": row["b"] ** 2 + 4}


A.select_to(transform, B)

# using a lambda for the transformation
# A.select_to(lambda row: {"name": row["a"] * 2, "square": row["b"] ** 2 + 4}, B)

print(B.to_text())
