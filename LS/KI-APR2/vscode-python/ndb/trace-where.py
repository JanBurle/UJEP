from typing import Mapping, TypeAlias

from NanoDB.nanodb import Column, ColumnType, DataType, Table, Value

TableMain = Table(
    "Main",
    [
        Column("id", ColumnType(DataType.INT, not_null=True, unique=True)),
        Column("name", ColumnType(DataType.TEXT, not_null=True)),
    ],
    primary_key=["id"],
)

MainRow: TypeAlias = tuple[int, str]

mainRows: list[MainRow] = [
    (1, "Alice"),
    (2, "Bob"),
    (3, "Cyril"),
]

for row in mainRows:
    TableMain.insert(("id", "name"), row)


def isId2(row: Mapping[str, Value]) -> bool:
    val = row["id"]
    return isinstance(val, int) and 2 == val


def isId(row: Mapping[str, Value], id: int) -> bool:
    val = row["id"]
    return isinstance(val, int) and id == val


# Bob
TableWhere = TableMain.where(isId2)
print(TableWhere.to_text())

# Alice
TableWhere = TableMain.where(lambda row: isId(row, 1))
print(TableWhere.to_text())
