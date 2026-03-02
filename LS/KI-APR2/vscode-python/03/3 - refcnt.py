class Book:
  _cnt: int = 0 # class variable, data "hiding"

  def __init__(self, name: str, abstract: str = ''):
    self.name     = name
    self.abstract = abstract
    print(f'New book: {self.name}')
    Book._cnt += 1

  def __del__(self):
    Book._cnt -= 1
    print(f'Deleted: {self.name}')

  @classmethod
  def count(cls) -> int:
    return cls._cnt

print(Book.count())
lotr = Book('Lord of the Rings')
print(Book.count())
silm = Book('Silmarillion')
print(Book.count())
del silm
print(Book.count())
del lotr
print(Book.count())
