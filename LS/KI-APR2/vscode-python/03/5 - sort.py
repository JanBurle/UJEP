class Book:
  def __init__(self, name: str, abstract: str = ''):
    self.name     = name
    self.abstract = abstract

#   def __lt__(self, other):
#     return self.name < other.name \
#       or self.name == other.name and self.abstract < other.abstract

#   def __repr__(self):
#     return self.name + '/' + self.abstract

l1 = Book('Lord of the Rings', 'First edition')
l2 = Book('Lord of the Rings', 'Second edition')

library = [l1, l2]
library.sort()  # Chyba, nelze porovnat

print(library)
