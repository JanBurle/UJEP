import weakref


class Book:
    def __init__(self, name: str):
        self._name = name

    @property
    def name(self) -> str:
        return self._name

    def __str__(self):
        return self.name

    def __lt__(self, other: "Book"):
        return self.name < other.name


class Library:
    def __init__(self):
        self._shelf: list[Book] = []
        self._dirty = False
        self._new: list[Book] = []
        self._iters = weakref.WeakSet()

    def add(self, book: Book):
        where = self._new if self._iters else self._shelf
        where.append(book)
        self._dirty = True

    def _cleanup(self):
        if self._dirty:
            self._shelf.sort()
            self._dirty = False

    def __iter__(self):
        self._cleanup()
        return LibraryIter(self)

    def _regIter(self, it: "LibraryIter"):
        self._iters.add(it)

    def _delIter(self, it: "LibraryIter"):
        self._iters.discard(it)
        if not self._iters:
            self._shelf.extend(self._new)
            self._new = []
            self._dirty = True


class LibraryIter:
    def __init__(self, lib: Library):
        self._lib = lib
        self._idx = 0
        self._lib._regIter(self)

    def __del__(self):
        self._lib._delIter(self)

    def __iter__(self):
        return self

    def __next__(self):
        shelf = self._lib._shelf
        idx = self._idx
        if len(shelf) <= idx:
            self._lib._delIter(self)
            raise StopIteration()
        self._idx += 1
        return shelf[idx]


if __name__ == "__main__":
    lib = Library()
    lib.add(Book("Zločin a trest"))
    lib.add(Book("Bratři Karamazovi"))
    lib.add(Book("Běsi"))
    lib.add(Book("Idiot"))

    # for book in lib:
    #     print(book)

    it1 = iter(lib)
    it2 = iter(lib)

    # print("it1:", next(it1))
    # print("it1:", next(it1))
    # print("it2:", next(it2))
    # print("it2:", next(it2))
    # print("it1:", next(it1))

    lib.add(Book("Zápisky z podzemí"))

    # print("it2:", next(it2))
    # print("it2:", next(it2))
    # print('it2:', next(it2))

    # for book in lib:
    #     print(book)

    for book in lib:
        print(book)

    del it1
    for book in lib:
        print(book)

    del it2
    for book in lib:
        print(book)
