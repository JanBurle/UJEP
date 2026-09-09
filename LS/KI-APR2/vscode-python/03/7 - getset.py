# class Person:
#   def __init__(self):
#     self.name = '<anonymous>'

#   def __str__(self) -> str:
#     return f'I am: {self.name}'

# person = Person()
# print(person)

# person.name = 'Alex'
# print(person)

# person.name = '' # problematic
# print(person)

# person.name = '666' # problematic
# print(person)

# # =============

# # with hidden data
# class Person:
#   def __init__(self):
#     self._name = '<anonymous>' # "protected" data member

#   def __str__(self) -> str:
#     return f'I am: {self._name}'

# person = Person()
# print(person)
# print(dir(person))
# person._name = 'Alex' # not quite protected, only marked as such
# print(person)

# # =============

# class Person:
#   def __init__(self):
#     self.__name = '<anonymous>' # "private"

#   def __str__(self) -> str:
#     return f'I am: {self.__name}'

# person = Person()
# print(person)
# print(dir(person))

# person.__name = 'Alex' # what is happening here?
# print(person)
# print(dir(person))

# person._Person__name = 'Alex' # Aha!
# print(person)

# # =============


class Person:
    def __init__(self):
        self.__name = "<anonymous>"

    def __str__(self) -> str:
        return f"I am: {self.__name}"

    @property
    def name(self) -> str:
        return self.__name

    @name.setter
    def name(self, name: str):
        if not name.isalpha():
            raise TypeError("Bad name!")
        self.__name = name[0].upper() + name[1:].lower()


person = Person()
print(person)
print(person.name)

person.name = "Alex"
print(person)
print(person.name)

person.name = "aLiCe"
print(person)  # Properly capitalized :)
print(person.name)

# person.name = ''  # TypeError: Bad name!
# person.name = ' ' # TypeError: Bad name!
# person.name = '8' # TypeError: Bad name!

# # =============
