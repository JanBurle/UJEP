class Book:
  def __init__(self, name: str, abstract: str = ''):
    self.name     = name
    self.abstract = abstract
    print(f'New book: {self.name}')

  def __del__(self):
    print(f'Deleted: {self.name}')

# --------------

lotr = Book('Lord of the Rings', 'One ring to rule them all!')
silm = Book('Silmarillion', 'Ainulindalë, Valaquenta, Quenta Silmarillion, Akallabêth, Of the Rings of Power and the Third Age')

del lotr

silm = 0

# --------------

library: list[Book] = []
library.append(Book('Lord of the Rings'))
library.append(Book('Silmarillion'))
library = []

# --------------

lotr = Book('Lord of the Rings', 'One ring to rule them all!') # první odkaz
tolk = lotr # dva odkazy
print('deleting lotr')
del lotr    # stále existuje jeden odkaz
print('deleting tolk')
del tolk    # žádný odkaz, objekt zrušen
