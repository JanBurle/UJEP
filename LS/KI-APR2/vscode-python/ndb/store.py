from datetime import date
from decimal import Decimal
from typing import Mapping

from NanoDB.nanodb import Column, ColumnType, DataType, Table, Value


class Store:
    def __init__(self):
        self._customer = Table(
            "customer",
            [
                Column("id", ColumnType(DataType.INT, not_null=True, unique=True)),
                Column("name", ColumnType(DataType.TEXT, not_null=True)),
                Column("birth_date", ColumnType(DataType.DATE)),
            ],
            primary_key=("id",),
        )

        self._customer_id_seq = 0

        self._order = Table(
            "order",
            [
                Column("id", ColumnType(DataType.INT, not_null=True, unique=True)),
                Column("customer_id", ColumnType(DataType.INT, not_null=True)),
                Column("total", ColumnType(DataType.DECIMAL, not_null=True)),
                Column("created", ColumnType(DataType.DATE, not_null=True)),
            ],
            primary_key=("id",),
        )

        self._order_id_seq = 0

    def __repr__(self) -> str:
        return self._customer.to_text() + "\n" + self._order.to_text()

    def add_customer(self, name: str, birth_date: date | None = None) -> int:
        """Přidá zákazníka do tabulky zákazníků a vrátí jeho ID."""
        self._customer_id_seq += 1
        id = self._customer_id_seq
        self._customer.insert(
            ("id", "name", "birth_date"),
            (id, name, birth_date),
        )
        return id

    def add_order(self, customer_id: int, total: Decimal, created: date) -> int:
        """Přidá objednávku do tabulky objednávek a vrátí její ID."""
        self._order_id_seq += 1
        id = self._order_id_seq
        self._order.insert(
            ("id", "customer_id", "total", "created"),
            (id, customer_id, total, created),
        )
        return id

    def get_customers(self) -> list[tuple[int, str]]:
        """Vrátí seznam zákazníků ve formátu (id, jméno)."""
        return [(row[0], row[1]) for row in self._customer]  # type: ignore[index]

    def _orders_where_customer_id(self, customer_id: int | None = None) -> Table:
        def cond(row: Mapping[str, Value]) -> bool:
            id = row["customer_id"]
            assert isinstance(id, int)
            return customer_id is None or id == customer_id

        return self._order.where(cond)

    def get_number_of_orders(self, customer_id: int | None = None) -> int:
        """Vrátí počet objednávek."""
        return len(self._orders_where_customer_id(customer_id))

    def get_total_order_value(self, customer_id: int | None = None) -> Decimal:
        """Vrátí celkovou sumu hodnot objednávek."""
        orders = self._orders_where_customer_id(customer_id)
        totals = orders.get_column("total")
        total = sum(totals) if totals else Decimal("0")  # type: ignore
        return total  # type: ignore

    def get_average_order_value(self, customer_id: int | None = None) -> Decimal:
        """Vrátí průměrnou hodnotu objednávky."""
        numOrders = self.get_number_of_orders(customer_id)
        if 0 == numOrders:
            return Decimal("0")
        return self.get_total_order_value(customer_id) / numOrders


if __name__ == "__main__":
    store = Store()

    id_alice = store.add_customer("Alice", date(1995, 5, 17))
    id_bob = store.add_customer("Bob")
    id_cyril = store.add_customer("Cyril", date(2001, 1, 10))

    store.add_order(id_alice, Decimal("120.50"), date(2026, 3, 1))
    store.add_order(id_alice, Decimal("75.00"), date(2026, 3, 2))
    store.add_order(id_bob, Decimal("33.30"), date(2026, 3, 3))
    store.add_order(id_cyril, Decimal("9.99"), date(2026, 3, 4))

    print(store)

    print("** Alice **")
    print("Počet objednávek:", store.get_number_of_orders(id_alice))
    print("Celková hodnota objednávek:", store.get_total_order_value(id_alice))
    print("Průměrná hodnota objednávky:", store.get_average_order_value(id_alice))

    print("** Celkem **")
    print("Počet objednávek:", store.get_number_of_orders())
    print("Celková hodnota objednávek:", store.get_total_order_value())
    print("Průměrná hodnota objednávky:", store.get_average_order_value())

    print("** Zákaznící **")
    for id, name in store.get_customers():
        print(f"{id} - {name:<8} ${store.get_total_order_value(id):4.2f}")
