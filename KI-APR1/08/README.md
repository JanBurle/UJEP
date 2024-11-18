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

Zjistěte, zda je seznam seřazený:

```python
def isSorted1(lst):
  return lst == sorted(lst)

isSorted1(numbers)
```

`sorted()` vrátí nový, seřazený seznam:

```python
help(sorted)
```

Zjistěte, zda je seznam seřazený, aniž by se vytvářel a řadil nový seznam:

```python
def isSorted2(lst):
  result = True
  for i in range(len(lst) - 1):
    result = result and lst[i] <= lst[i+1]
  return result

isSorted2(numbers)
```

Použijeme předčasný návrat z funkce:

```python
def isSorted3(lst):
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

My budeme nicméně dnes psát uživatelské, pomalejší funkce, kvůli procvičování algoritmů.

### 📱 Úloha

Seznam `backward` je sice seřazený, ale opačně (sestupně).

```python
isSorted1(backward) # False
```

Napište funkci, která zjistí, jestli je seznam seřazený libovolným směrem, a vrátí hodnotu:

- +1 pokud je seznam seřazený vzestupně (0, 1, 2, ...)
- 0 pokud seznam není seřazený
- -1 pokud je seznam seřazený sestupně

```python
def isSorted4(lst: list) -> int:
  ...

isSorted4(numbers)
isSorted4(backward)
isSorted4(words)
isSorted4(unsorted)
```

### Vestavěné funkce

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

### Heterogenní seznamy

Prvky heterogenního seznamu nelze jednodušše porovnávat:

```python
isSorted2(mixed) # výjimka
```

Napišme si funkci na porovnání dvou hodnot:

```python
def compare(a,b) -> bool:
  """Is a less than or equal to b?"""
  return a <= b

compare(2,3)      # ok
compare('x','y')  # ok
compare(2,'y')    # NOT ok
```

Vestavěnou funkcí `isinstance()` lze zjistit, jestli hodnota má určitý typ:

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

Funkci lze i zkrát:

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

### 📱 Úloha: řazení

Pro procvičení naprogramujte funkci, která "in-place" seřadí seznam pomocí algoritmu [bublinkového řazení](https://cs.wikipedia.org/wiki/Bublinkov%C3%A9_%C5%99azen%C3%A), nebo i jiného [řadicího algoritmu](https://cs.wikipedia.org/wiki/Kategorie:%C5%98adic%C3%AD_algoritmy).
