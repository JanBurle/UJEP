# OrderedList - strategy 4, sorting only when an element is requested


class OrderedListError(Exception):
    pass


class OrderedList:
    def __init__(self):
        self._items = []
        self._dirty = False  # dirty = needs sorting

    def size(self) -> int:
        return len(self._items)

    def add(self, item):
        self._items.append(item)
        self._dirty = True
        return self  # for chaining

    def __make_clean(self):
        if self._dirty:
            self._items.sort()
            self._dirty = False

    def get(self, i: int) -> object:
        self.__make_clean()  # the guard
        try:
            return self._items[i]
        except IndexError:
            raise OrderedListError("bad index")

    def pop(self, i: int) -> object:
        self.__make_clean()  # the guard
        try:
            return self._items.pop(i)
        except IndexError:
            raise OrderedListError("bad index")


if __name__ == "__main__":
    o = OrderedList()
    o.add(2).add(1).add(4).add(3)

    for i in range(o.size()):
        print(o.get(i))

    while o.size():
        print("pop:", o.pop(o.size() - 1))
