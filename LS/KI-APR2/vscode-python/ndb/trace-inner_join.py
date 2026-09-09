from typing import TypeAlias

from NanoDB.nanodb import Column, ColumnType, DataType, Table

TableMain = Table(
    "Main",
    [
        Column("id", ColumnType(DataType.INT, not_null=True, unique=True)),
        Column("name", ColumnType(DataType.TEXT, not_null=True)),
    ],
    primary_key=["id"],
)

TableDetail = Table(
    "Detail",
    [
        Column("id", ColumnType(DataType.INT, not_null=True, unique=True)),
        Column("main_id", ColumnType(DataType.INT)),
        Column("name", ColumnType(DataType.TEXT, not_null=True, unique=True)),
    ],
    primary_key=["id"],
)

MainRow: TypeAlias = tuple[int, str]
DetailRow: TypeAlias = tuple[int, int | None, str]

mainRows: list[MainRow] = [
    (1, "Alice"),
    (2, "Bob"),
    (3, "Cyril"),
]

for row in mainRows:
    TableMain.insert(("id", "name"), row)

detailRows: list[DetailRow] = [
    (1, 1, "Detail 1"),
    (2, 1, "Detail 2"),
    (3, 2, "Detail 3"),
    (4, None, "Detail 4"),
]

for row in detailRows:
    TableDetail.insert(("id", "main_id", "name"), row)

TableJoined = TableMain.inner_join(TableDetail, ("main_id",))

print(TableJoined.to_text())
