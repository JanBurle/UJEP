# def isSorted4(lst: list) -> bool:

Napište funkci, která zjistí, jestli je seznam seřazený libovolným směrem.

```python
def isSorted4(lst: list) -> bool:
  return isSorted1(lst) or isSorted1(list(reversed(lst)))
```

```python
def isSorted4(lst:list) -> bool:
  upward   = all(lst[i]<=lst[i+1] for i in range(len(lst)-1))
  downward = all(lst[i]>=lst[i+1] for i in range(len(lst)-1))
  return upward or downward
```

```python
def isSorted4(lst: list) -> bool:
  if len(lst) < 3: return True # corner cases

  dir = 0 # direction 0: not known, +1 up, -1 down
  for i in range(0, len(lst)-1):
    a, b = lst[i:i+2]
    if dir < 0:
      if a < b: return False
    elif 0 < dir:
      if a > b: return False
    else:
      if a < b: dir = +1
      elif a > b: dir = -1

  return True

isSorted4([])
isSorted4([0])
isSorted4(numbers)
isSorted4(backward)
isSorted4(words)
isSorted4(unsorted)
```

Bez použití vestavěných funkcí `min(), max(), sum(), ...` napište funkce, které (pomocí cyklu)

- najdou v seznamu nejmenší prvek
- najdou v seznamu největší prvek
- sečtou prvky (čísla)
- vynásobí prvky (čísla)

Nejdříve se zamyslete nad tím, jaký výsledek by funkce měly vrátit pro prázdný seznam.

```python
def myMin(lst:list):
  if not list: return None
  min = lst[0]
  for elem in lst[1:]:
    if elem<min: min = elem

  return min

myMin([1, 3, 2, -1, 4, 5])
```

```python
# def myMax ...
```

```python
def mySum(lst: list[int|float]) -> int|float:
  sum = 0
  for elem in lst:
    sum += elem

  return sum

mySum([1, 3, 2, -1, 4, 5.6])
```

```python
# def myProduct ...
```

Rozšiřte vaše funkce, které najdou v seznamu nejmenší a největší prvek, tak aby vrátily dvojici (index prvku, hodnota prvku).

```python
def myMin(lst:list):
  res = None
  for i,elem in enumerate(lst):
    if not res or elem<res[1]:
      res = (i,elem)

  return res

myMin([-11, 3, 2, -1, 4, 5])
# myMin([])
```

Pomocí vestavěných funkcí _min(), max(), sorted()_ a lambda funkce použité jako parametr _key_:

- najděte bod s nejmenší/největší souřadnicí x, y, z
- vypište seznam bodů seřazený podle souřadice x, y, z

Např.:

```python
# y:
min(points, key=lambda point: point[1])
```

```python
# z:
sorted(points, key=lambda point: point[2])
```

Pro procvičení napište funkci, která bez použití vestavěných funkcí `reversed(...)` a `...reverse()` obrátí seznam a to ¨in-place¨.

```python
def reverseInPlace(lst: list):
  for i in range(len(lst)//2):
    lst[i], lst[-1-i] = lst[-1-i], lst[i]
```

Pro procvičení naprogramujte funkci, která "in-place" seřadí seznam pomocí algoritmu [bublinkového řazení](https://cs.wikipedia.org/wiki/Bublinkov%C3%A9_%C5%99azen%C3%A), nebo i jiného [řadicího algoritmu](https://cs.wikipedia.org/wiki/Kategorie:%C5%98adic%C3%AD_algoritmy).

```python
def bubbleSort(lst: list):
  sorted = False # run the loop at least once
  while not sorted:
    print(lst)    # trace print
    sorted = True # assumption
    for i in range(len(lst)-1):
      if not lst[i] <= lst[i+1]:
        lst[i],lst[i+1] = lst[i+1],lst[i]
        sorted = False # assumption was wrong, must redo

import random
bubbleSort([random.randint(10,99) for _ in range(18)])
```

```python
def cocktailSort(lst:list):
  def needsSwap(i):
    j = i+1
    if lst[i] <= lst[j]: return False
    lst[i],lst[j] = lst[j],lst[i]
    return True

  start = 0; end = len(lst) - 1

  print(lst)
  while True:
    # forth
    sorted = True
    for i in range(start, end):
      if needsSwap(i): sorted = False
    if sorted:
      break
    print(lst)

    end -= 1

    # back
    sorted = True
    for i in range(end-1, start-1, -1):
      if needsSwap(i): sorted = False
    if sorted:
      break
    print(lst)

    start += 1

import random
lst = list(range(10,20))
random.shuffle(lst)

cocktailSort(lst)
```

```python
def mySort(lst: list):
  ll = len(lst)

  def swap(i,j):
    lst[i],lst[j] = lst[j],lst[i]

  def minIdx(fromI):
    return min(range(fromI,ll), key=lambda i: lst[i])

  print(lst)
  for i in range(ll-1):
    swap(i,minIdx(i))
    print(lst)

import random
lst = list(range(10,20))
random.shuffle(lst)

mySort(lst)
```
