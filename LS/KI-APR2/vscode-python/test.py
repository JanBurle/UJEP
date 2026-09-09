import sys

print("Python version:", sys.version)


class Aardvark:
    pass


print(Aardvark.__bases__)  # (<class 'object'>,)
print((9).__class__.__bases__)  # (<class 'object'>,)
print(int.__bases__)  # ()
print(object.__bases__)  # ()

x = (9).__class__  # <class 'int'>

print(x.__class__)  # <class 'int'>
# print(int.__bases__[0].__bases__[0])
