# OrderedList - strategy 1, sorting after each addition of an element


class OrderedListError(Exception):
    # def __init__(self, msg: str):
    #     super().__init__(msg)
    pass


class OrderedList:
    def __init__(self):
        self._items = []

    def isEmpty(self) -> bool:
        return 0 == self.size()

    def size(self) -> int:
        return len(self._items)

    def add(self, item) -> "OrderedList":
        self._items.append(item)
        self._items.sort()
        # for chaining of add().add().add() ... return self
        return self

    def get(self, i: int) -> object:
        try:
            return self._items[i]
        except IndexError:
            raise OrderedListError("bad index")

    def pop(self, i: int) -> object:
        try:
            return self._items.pop(i)
        except IndexError:
            raise OrderedListError("bad index")

    def __str__(self):
        return str(self._items)


if __name__ == "__main__":
    o = OrderedList()
    o.add(2).add(1).add(4).add(3)

    print(o)

    for i in range(o.size()):
        print(i, o.get(i))

    # while not o.isEmpty():
    while o.size():
        print("pop:", o.pop(o.size() - 1))
