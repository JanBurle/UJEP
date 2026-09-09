import weakref
from dataclasses import dataclass
from typing import Iterator


@dataclass(order=True, frozen=True)
class Book:
    name: str

    def __str__(self) -> str:
        return self.name


class Library:
    def __init__(self):
        self._shelf: list[Book] = []
        self._dirty = False
        self._new: list[Book] = []
        self._iters = weakref.WeakSet()

    def add(self, book: Book):
        if self._iters:
            self._new.append(book)
        else:
            self._shelf.append(book)
            self._dirty = True

    def _cleanup(self):
        if self._dirty:
            self._shelf.sort()
            self._dirty = False

    def __iter__(self) -> Iterator[Book]:
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
        self._closed = False
        self._lib._regIter(self)

    def close(self):
        if not self._closed:
            self._closed = True
            self._lib._delIter(self)

    def __del__(self):
        try:
            self.close()
        except Exception:
            pass

    def __iter__(self) -> "LibraryIter":
        return self

    def __next__(self) -> Book:
        shelf = self._lib._shelf
        idx = self._idx

        if self._closed:
            raise StopIteration()

        if len(shelf) <= idx:
            self.close()
            raise StopIteration()

        self._idx += 1
        return shelf[idx]


if __name__ == "__main__":
    lib = Library()

    lib.add(Book("Zločin a trest"))
    lib.add(Book("Bratři Karamazovi"))
    lib.add(Book("Běsi"))
    lib.add(Book("Idiot"))

    for book in lib:
        print(book)

    it1 = iter(lib)
    it2 = iter(lib)

    print("it1:", next(it1))
    print("it1:", next(it1))
    print("it2:", next(it2))
    print("it2:", next(it2))
    print("it1:", next(it1))

    lib.add(Book("Zápisky z podzemí"))

    print("it2:", next(it2))
    print("it2:", next(it2))

    try:
        next(it2)
    except StopIteration:
        print("it2: StopIteration")

    for book in lib:
        print(book)

    for book in lib:
        print(book)

    del it1
    for book in lib:
        print(book)

    del it2
    for book in lib:
        print(book)
