from typing import Optional as Opt


class Author:
    def __init__(self, name: str, birth_year: int, biography: str = ""):
        self.name = name
        self.birth_year = birth_year
        self.biography = biography

    # def __str__(self) -> str: # type annotation is optional, not needed
    def __str__(self):
        return f"{self.name} (Born: {self.birth_year})"

    def __repr__(self):
        return f"Author(name={self.name!r}, birth_year={self.birth_year!r}, biography={self.biography!r})"

    # Not: def __eq__(self, other: 'Author'):
    # Yes: def __eq__(self, other: object):
    def __eq__(self, other):
        # return isinstance(other, Author) \
        #     and self.name == other.name and self.birth_year == other.birth_year
        return self.name == other.name and self.birth_year == other.birth_year

    def __lt__(self, other):
        # return (
        #     self.name < other.name
        #     or self.name == other.name
        #     and self.birth_year < other.birth_year
        # )
        if self.name < other.name:
            return True
        if self.name == other.name:
            return self.birth_year < other.birth_year
        return False


class Book:
    def __init__(self, name: str, abstract: str = ""):
        self.name = name
        self.abstract = abstract

    def __eq__(self, other):
        return self.name == other.name

    def __lt__(self, other):
        return (
            self.name < other.name
            or self.name == other.name
            and self.abstract < other.abstract
        )

    def __str__(self):
        return self.name

    def __repr__(self):
        return str(self) + "/" + self.abstract


class Shelf:
    def __init__(self, name):
        self.name = name
        self.books = []

    def __str__(self):
        return f"Shelf '{self.name}' contains {len(self.books)} books."

    def __repr__(self):
        return f"Shelf(name={self.name!r}, books={self.books!r})"

    def add_book(self, book: Book):
        self.books.append(book)

    def remove_book(self, book: Book) -> bool:
        if book in self.books:
            self.books.remove(book)
            return True
        return False
        # if book not in self.books:
        #     return False

        # self.books.remove(book)
        # return True

    def search_books(
        self, title: Opt[str] = None, author: Opt[Author] = None, year: Opt[int] = None
    ) -> list[Book]:
        books = []
        for book in self.books:
            if (
                (title is None or title.lower() in book.title.lower())
                and (author is None or author == book.author)
                and (year is None or year == book.year)
            ):
                books.append(book)
        return books

    def list_books(self):
        return "\n".join(str(book) for book in self.books)


class Reader:
    def __init__(self, name):
        self.name = name
        self.borrowed_books = []

    def __str__(self):
        return f"{self.name}, borrowed books: {', '.join(str(book) for book in self.borrowed_books)}"

    def borrow(self, book):
        if book not in self.borrowed_books:
            self.borrowed_books.append(book)
            return f"{self.name} borrowed '{book.title}'."
        return f"{self.name} has already borrowed '{book.title}'."

    def return_book(self, book):
        if book in self.borrowed_books:
            self.borrowed_books.remove(book)
            return f"{self.name} returned '{book.title}'."
        return f"{self.name} did not borrow '{book.title}'."


class Library:
    def __init__(self):
        self.shelves = {}

    def __str__(self):
        return f"Library contains {len(self.shelves)} shelves."

    def __repr__(self):
        return f"Library(shelves={self.shelves!r})"

    def add_shelf(self, shelf):
        self.shelves[shelf.name] = shelf

    def remove_shelf(self, shelf_name):
        if shelf_name in self.shelves:
            del self.shelves[shelf_name]
            return f"Shelf '{shelf_name}' has been removed from the library."
        return f"Shelf '{shelf_name}' not found."

    def add_book_to_shelf(self, shelf_name, book):
        if shelf_name in self.shelves:
            self.shelves[shelf_name].add_book(book)
        else:
            return f"Shelf '{shelf_name}' not found in the library."

    def remove_book_from_shelf(self, shelf_name, book):
        if shelf_name in self.shelves:
            return self.shelves[shelf_name].remove_book(book)
        return f"Shelf '{shelf_name}' not found."

    def search_books(self, title=None, author=None, year=None, shelf_name=None):
        results = []
        if shelf_name:
            if shelf_name in self.shelves:
                results.extend(
                    self.shelves[shelf_name].search_books(title, author, year)
                )
            else:
                return f"Shelf '{shelf_name}' not found."
        else:
            for shelf in self.shelves.values():
                results.extend(shelf.search_books(title, author, year))
        return results

    def list_books(self):
        result = []
        for shelf in self.shelves.values():
            result.append(f"{shelf.name}:\n" + shelf.list_books())
        return "\n".join(result)


# Example usage:

# Creating authors

author1 = Author(
    "George Orwell", 1903, "English novelist andessayist, journalist and critic."
)
author2 = Author(
    "Harper Lee", 1926, "American novelist best known for 'To Kill a Mockingbird'."
)
author3 = Author(
    "Aldous Huxley",
    1894,
    "English writer and philosopher, best known for 'Brave New World'.",
)

# Creating books

book1 = Book("1984", author1, 1949)
book2 = Book("To Kill a Mockingbird", author2, 1960)
book3 = Book("Brave New World", author3, 1932)

# Creating shelves

shelf1 = Shelf("Classics")
shelf2 = Shelf("Science Fiction")

# Creating readers

reader1 = Reader("Alice")
reader2 = Reader("Bob")

# Creating a library and adding shelves

library = Library()
library.add_shelf(shelf1)
library.add_shelf(shelf2)

# Adding books to shelves

library.add_book_to_shelf("Classics", book1)
library.add_book_to_shelf("Classics", book2)
library.add_book_to_shelf("Science Fiction", book3)

# Searching books in the library by author

print("Search results for 'George Orwell':", library.search_books(author=author1))

# Borrowing books

print(reader1.borrow(book1))
print(reader2.borrow(book2))

# Listing borrowed books

print(reader1)
print(reader2)

# Returning books

print(reader1.return_book(book1))
print(reader2.return_book(book2))

# Listing all books in the library

print("\nLibrary with shelves and books:")
print(library.list_books())

# Removing a book from a shelf

print(library.remove_book_from_shelf("Classics", book1))

# Listing books after removal

print("\nLibrary after removing '1984' from Classics shelf:")
print(library.list_books())
