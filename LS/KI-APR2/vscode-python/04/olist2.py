# OrderedList - strategy 2, sorting during insertion of an element

## Prototype of code that sequentially finds the position for inserting element `x` (O(n))
## and adds the element


def findPos(x: int):
    for i, val in enumerate(lst):
        if x < val:
            return i
    return len(lst)


def add(x: int):
    i = findPos(x)
    lst.insert(i, x)


lst = [1, 2, 3, 3, 4]
add(2.4)
print(lst)

## Your task: add this strategy into class `OrderedList`,
## (also add type annotations),
## test it, and compare its performance with strategy 1
## (sorting after each addition of an element).
