# def isSorted4(lst: list) -> bool:

Napište funkci, která zjistí, jestli je seznam seřazený libovolným směrem.

```python
def isSorted4(lst: list) -> bool:
  return isSorted1(lst) or isSorted1(list(reversed(lst)))
```

```python
def isSorted4(lst: list) -> bool:
  if len(lst) < 2: return True # corner cases

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
