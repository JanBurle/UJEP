# OrderedList - strategy 3, sorting at insertion, _binary search_:

## Strategie 3, řazení při vkládání, _binární vyhledávání_ (O(log n)), prototype:

## Recursion:


def _findPos1(x, lo, hi):
    if lo == hi:
        return lo
    mid = (lo + hi) // 2
    return _findPos1(x, lo, mid) if x < lst[mid] else _findPos1(x, mid + 1, hi)


def findPos1(x):
    return _findPos1(x, 0, len(lst))


## Iteration:


def findPos2(x):
    lo = 0
    hi = len(lst)

    while lo < hi:
        mid = (lo + hi) // 2
        if x < lst[mid]:
            hi = mid
        else:
            lo = mid + 1
    return lo


lst = [1, 2, 3, 3, 4]

x = 2.4
i = findPos1(x)
lst.insert(i, x)

x = 3.4
i = findPos2(x)
lst.insert(i, x)

print(lst)

## Your task: add this strategy into class `OrderedList`,
## (also add type annotations),
## test it, and compare its performance with strategy 2
