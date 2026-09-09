class Book:
    def __init__(self, name: str, abstract: str = ""):
        self.name = name
        self.abstract = abstract
        print(f"New book: {self.name}")

    def __del__(self):
        print(f"Deleted: {self.name}")

    def __eq__(self, other):
        return self.name == other.name

    def __lt__(self, other):
        return (
            self.name < other.name
            or self.name == other.name
            and self.abstract < other.abstract
        )


l1 = Book("Lord of the Rings", "First edition")
l2 = Book("Lord of the Rings", "Second edition")

print(l1 == l1)  # True, je to stejný objekt (zdědená metoda)
print(l1 != l1)  # False

print(l1 == l2)  # False, jiný objekt
print(l1 != l2)  # True

print(l1 < l1)  # Chyba, nelze porovnat

print(l1 < l2)
print(l1 <= l2)
print(l1 > l2)
print(l1 >= l2)
