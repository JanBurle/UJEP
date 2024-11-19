# 08 – Operace nad seznamy (řazení)

Vytvořte si seznamy:

```python
numbers  = [1, 2, 3, 4, 5]               # homogenní, celá čísla
unsorted = [1, 3, 2, 4, 5]
backward = list(reversed(numbers))
longOne1 = list(range(1000))
longOne2 = list(range(10_000))
words    = ["apple", "banana", "cherry"] # homogenní, řetězce
mixed    = [1, "hello", 3.14]            # heterogenní
```

## Seřazené seznamy

Zjistěte, zda je seznam seřazený:

```python
def isSorted1(lst:list) -> bool:
  return lst == sorted(lst)

# isSorted1([]) # ?
isSorted1(numbers)
# isSorted1(reversed(backward)) # type annotation!
```

`sorted()` vrátí nový, seřazený seznam:

```python
help(sorted)
```

Zjistěte, zda je seznam seřazený, aniž by se vytvářel a řadil nový seznam:

```python
def isSorted2(lst:list) -> bool:
  result = True
  for i in range(len(lst) - 1):
    result = result and lst[i] <= lst[i+1]
  return result

isSorted2(numbers)
```

Nebo:

```python
def isSorted2b(lst:list) -> bool:
  result = True
  for i in range(1, len(lst)):
    result = result and lst[i-1] <= lst[i]
  return result

isSorted2b(numbers)
```

Použijeme předčasný návrat z funkce:

```python
def isSorted3(lst:list) -> bool:
  for i in range(len(lst) - 1):
    if not lst[i] <= lst[i+1]:
      return False
  return True

isSorted3(unsorted)
```

Přestože `isSorted1()` vytváří a řadí seznam, je nejrychlejší, protože je (kompilovanou) součástí jazyka:

```python
%time isSorted1(longOne2)
%time isSorted2(longOne2)
%time isSorted3(longOne2)
```

My budeme nicméně dnes psát uživatelské, pomalejší funkce, abychom si procvičili algoritmy.

### 📱 Úloha

Seznam `backward` je sice seřazený, ale opačně (sestupně):

```python
isSorted1(backward) # False
```

Napište funkci, která zjistí, jestli je seznam seřazený libovolným směrem.

```python
def isSorted4(lst: list) -> bool:
  ...

isSorted4(numbers)
isSorted4(backward)
isSorted4(words)
isSorted4(unsorted)
```

## Vestavěné funkce min, max, sum

Vestavěné funkce `min()` a `max()` naleznou v seznamu nejmenší a největší hodnotu:

```python
min(numbers)
max(numbers)
min(words)
max(words)
```

Nad seznamem čísel lze také použít vestavěnou funkci `sum()`, která čísla sečte:

```python
sum(numbers)
```

Ale ne:

```python
sum(words)
```

### 📱 Úloha

Bez použití vestavěných funkcí `min(), max(), sum(), ...` napište funkce, které (pomocí cyklu)

- najdou v seznamu nejmenší prvek
- najdou v seznamu největší prvek
- sečtou prvky (čísla)
- vynásobí prvky (čísla)

Nejdříve se zamyslete nad tím, jaký výsledek by funkce měly vrátit pro prázdný seznam.

### 📱 Úloha

Rozšiřte vaše funkce, které najdou v seznamu nejmenší a největší prvek, tak aby vrátily dvojici (index prvku, hodnota prvku).

Nápověda:

```python
for elem in mixed:
  print(elem)

for i in range(len(mixed)):
  print(i)

# Takto?
for i,elem in enumerate(mixed):
  print(i,elem)
```

## Heterogenní seznamy

Prvky heterogenního seznamu nelze jednoduše porovnávat:

```python
isSorted2(mixed) # výjimka
```

Napišme si funkci na porovnání dvou hodnot:

`compare` by se také mohlo jmenovat

- `lt`: less than
- `le`: less than or equal
- `gt`: greater than
- `ge`: greater than or equal
- `eq`: equal
- `ne`: not equal

```python
def compare(a,b) -> bool:
  """Is a less than or equal to b?"""
  return a <= b

compare(2,3)      # ok
compare('x','y')  # ok
compare(2,'y')    # NOT ok
```

Vestavěnou funkcí `isinstance()` lze za běhu programu zjistit, zda hodnota má určitý typ:

```python
i = 3
f = 3.14
s = 'abc'

# integer?
isinstance(i, int)
isinstance(f, int)
isinstance(s, int)

# float?
isinstance(i, float)
isinstance(f, float)
isinstance(s, float)

# string?
isinstance(i, str)
isinstance(f, str)
isinstance(s, str)

# number?
isinstance(i, (int, float))
isinstance(f, (int, float))
isinstance(s, (int, float))
```

A pak lze napsat funkci, která porovná čísla i řetězce:

```python
def compare(a: int|float|str, b: int|float|str) -> bool:
  """Compare numbers or strings. Numbers come first."""
  if isinstance(a, str):
    return a<=b if isinstance(b, str) else False
  else:
    return True if isinstance(b, str) else a<=b
```

Funkci lze i zkrátit:

```python
def compare(a: int|float|str, b: int|float|str) -> bool:
  if isinstance(a, str) == isinstance(b, str):
    return a <= b # a and b are either both strings, or both numbers
  return isinstance(b, str) # string/number, True if b is string
```

### 📱 Úloha

Upravte vaši funkci (např.) `isSorted4()` tak, aby dokázala určit zda heterogenní seznam je seřazen:

```python
isSorted4(mixed)
```

## Adaptace vestavěných funkcí

Vestavěné funkce _min(), max(), sorted(), list.sort()_ lze adaptovat pomocí pojmenovaného parametru _key_:

```python
help(min)
help(max)
help(sorted)
help(list.sort)
```

#### Hráči – úloha z minulého cvičení

Mějme seznam hráčů a jejich skóre v turnaji. Vypište jméno nejlepšího a nejhoršího hráče (podle skóre).

```python
hráči = [("Pavel", 3), ("Honza", 5), ("Jana", 7), ("Milan", 4), ("Michaela", 9)]
```

Funkce _max_ vypíše "největší" prvek seznamu, podle abecedy:

```python
max(hráči)
```

Napíšeme-li funkci, která vrací skóre hráče, a předáme-li ji jako parametr _key_, dostaneme hráče s největším skóre:

```python
def score(hráč):
  return hráč[1]

max(hráči, key=score)
```

Nebo hráče s nejmenším skóre:

```python
min(hráči, key=score)
```

Nebo seznam hráčů setříděný podle skóre:

```python
sorted(hráči, key=score)
```

### Anonymní (lambda) funkce

[Anonymní funkce](https://en.wikipedia.org/wiki/Anonymous_function) je funkční objekt zapsaný bez pomoci klíčového slova `def` a bez jména. Anonymní funkci lze použít např. jako přímý argument (literál) pro adoptaci vestavěných funkcí:

```python
min(hráči, key=lambda x: x[1])
```

```python
max(hráči, key=lambda x: x[1])
```

### 📱 Úloha

Máme seznam 3D bodů:

```python
from random import uniform as uniRnd

def randomPoint(scale = 100):
  x = uniRnd(-scale, +scale)
  y = uniRnd(-scale, +scale)
  z = uniRnd(-scale, +scale)
  return (x,y,z)

points = []
for _ in range(60):
  points.append(randomPoint())

points
```

Pomocí vestavěných funkcí _min(), max(), sorted()_ a lambda funkce použité jako parametr _key_:

- najděte bod s nejmenší/největší souřadnicí x, y, z
- vypište seznam bodů seřazený podle souřadice x, y, z

## Řazení seznamů

### 📱 Úloha

Pro procvičení napište funkci, která bez použití vestavěných funkcí `reversed(...)` a `...reverse()` obrátí seznam a to ¨in-place¨.

```python
def reverseInPlace(lst: list):
  for i in ...
    ...

a = [2,4,3,5]
reverseInPlace(a)
a
# [5, 3, 4, 2]
```

### 📱 Úloha

Pro procvičení naprogramujte funkci, která "in-place" seřadí seznam pomocí algoritmu [bublinkového řazení](https://cs.wikipedia.org/wiki/Bublinkov%C3%A9_%C5%99azen%C3%A), nebo i jiného [řadicího algoritmu](https://cs.wikipedia.org/wiki/Kategorie:%C5%98adic%C3%AD_algoritmy).

```python
def bubbleSort(lst: list):
  ...

a = [5,4,2,3,1]
bubbleSort(a)
a
# [1, 2, 3, 4, 5]
```
