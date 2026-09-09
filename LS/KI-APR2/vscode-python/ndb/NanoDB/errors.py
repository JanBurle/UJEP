from decimal import Decimal

from nanodb import Column, ColumnType, DataType, Table


def test_errors() -> None:
    """Demonstrate selected constraint violations."""
    person = Table(
        "person",
        [
            Column("id", ColumnType(DataType.INT, not_null=True, unique=True)),
            Column("name", ColumnType(DataType.TEXT, not_null=True)),
            Column("salary", ColumnType(DataType.DECIMAL)),
        ],
        primary_key=("id",),
    )

    person.insert(("id", "name", "salary"), (1, "Alice", Decimal("10.50")))

    try:
        person.insert(("id", "name"), (1, "Bob"))
    except ValueError as exc:
        print("Duplicate primary key:", exc)

    try:
        person.insert(("id", "name"), (2, None))
    except ValueError as exc:
        print("NOT NULL violation:", exc)

    try:
        person.insert(("id", "name", "salary"), (3, "Cyril", 10.5))  # type: ignore
    except TypeError as exc:
        print("Invalid DECIMAL type:", exc)

    try:
        person.insert(("unknown_column",), (123,))
    except ValueError as exc:
        print("Unknown column:", exc)


if __name__ == "__main__":
    test_errors()
