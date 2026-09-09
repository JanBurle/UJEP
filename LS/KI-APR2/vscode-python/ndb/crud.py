from typing import Callable, Sequence

from NanoDB.nanodb import Mapping, Row, Table, Value


class MyTable(Table):
    def materializedView(
        self,
        column_names: Sequence[str],
    ) -> Table:
        """
        Creates and returns a new table containing only the given column names.
        The new table should have the same number of rows as the original table,
        and the values of the given columns in the new table should be the same as in
        the original table. The primary key of the new table should be the same
        as the primary key of the original table (the names of the primary key columns
        do not need to be specified).
        """
        return self

    def orderBy(
        self,
        lt: Callable[[Row, Row], bool],
    ) -> Table:
        """
        Creates and returns a new table with the same columns and rows as the original
        table, but sorted using the given less-than function (predicate) `lt`.
        """
        return self

    def delete(self, where_cond: Callable[[Mapping[str, Value]], bool]) -> None:
        """
        Deletes all rows from the table that satisfy the given condition (predicate).
        """
        pass

    ...
    # more methods to implement as you wish

if __name__ == "__main__":
    # Example usage:
    # t = MyTable(...)
    # t.materializedView(...)
    # t.orderBy(...)
    # t.delete(...)
