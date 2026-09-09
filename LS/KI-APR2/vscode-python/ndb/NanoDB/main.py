from datetime import date
from decimal import Decimal

from nanodb import Column, ColumnType, DataType, Table


def main() -> None:
    """Create sample tables, insert data, and demonstrate inner join."""
    customer = Table(
        "customer",
        [
            Column("id", ColumnType(DataType.INT, not_null=True, unique=True)),
            Column("name", ColumnType(DataType.TEXT, not_null=True)),
            Column("birth_date", ColumnType(DataType.DATE)),
        ],
        primary_key=("id",),
    )

    order_tbl = Table(
        "order",
        [
            Column("id", ColumnType(DataType.INT, not_null=True, unique=True)),
            Column("customer_id", ColumnType(DataType.INT)),
            Column("total", ColumnType(DataType.DECIMAL, not_null=True)),
            Column("created", ColumnType(DataType.DATE, not_null=True)),
        ],
        primary_key=("id",),
    )

    customer.insert(
        ("id", "name", "birth_date"),
        (1, "Alice", date(1995, 5, 17)),
    )
    customer.insert(
        ("id", "name", "birth_date"),
        (2, "Bob", None),
    )
    customer.insert(
        ("id", "name", "birth_date"),
        (3, "Cyril", date(2001, 1, 10)),
    )

    order_tbl.insert(
        ("id", "customer_id", "total", "created"),
        (100, 1, Decimal("120.50"), date(2026, 3, 1)),
    )
    order_tbl.insert(
        ("id", "customer_id", "total", "created"),
        (101, 1, Decimal("75.00"), date(2026, 3, 2)),
    )
    order_tbl.insert(
        ("id", "customer_id", "total", "created"),
        (102, 2, Decimal("33.30"), date(2026, 3, 3)),
    )
    order_tbl.insert(
        ("id", "customer_id", "total", "created"),
        (103, None, Decimal("9.99"), date(2026, 3, 4)),
    )
    order_tbl.insert(
        ("id", "customer_id", "total", "created"),
        (104, 999, Decimal("15.00"), date(2026, 3, 5)),
    )

    print("CUSTOMER")
    print(customer.to_text())
    print()

    print("ORDER")
    print(order_tbl.to_text())
    print()

    joined = customer.inner_join(order_tbl, ("customer_id",))

    print("INNER JOIN: customer ⨝ order")
    print(joined.to_text())
    print()

    print("Rows in customer:", len(customer))
    print("Rows in order:", len(order_tbl))
    print("Rows in join:", len(joined))
    print()

    print("Iterating over joined rows:")
    for row in joined:
        print(row)

    ac = customer.where(lambda row: row["name"].startswith("A"))  # type: ignore
    print(ac.to_text())


if __name__ == "__main__":
    main()
