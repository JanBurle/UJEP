## [PB09](https://github.com/pavelberanek91/UJEP/blob/main/APR1/Cvi%C4%8Den%C3%AD%209/README.md)

## Časová složitost algoritmů

Jak dlouho trvá (kolik času, kolik kroků) provedení algoritmu, v závislosti na počtu prvků `n` (např. počet položek v seznamu).

### Měření času

`longCalc()` by měl mít složitost O(n), to jest čas lineárně rostoucí s počtem prvků:

```python
import time

def longCalc(n:int): # potentially long calculation
  for _ in range(n):
    pass

ns = [n*1000 for n in range(1,10)]

print(f'n\ttime\t\ttime/n')
for n in ns:
  begTime = time.time()       # begin
  longCalc(n)
  endTime = time.time()       # end
  delta = endTime - begTime   # time spent in algorithm

  print(f'{n}\t{delta:.9f}\t{delta/n:.3g}')
```

Poněkud jinak:

```python
from collections.abc import Callable

def measureTime(f:Callable[[int],None], n:int):
  import time
  begin = time.time()
  f(n)
  delta = time.time() - begin

  return (n, delta)

def longCalc(n:int):
  for _ in range(n):
    pass

ns = [n*10_000 for n in range(1,30)]
measurements = [measureTime(longCalc,n) for n in ns]

# print measured results
print(*measurements, sep='\n')

# calculate average time for one pass
import statistics, math
avgTime = statistics.fmean([time/n for n,time in measurements])

# if the algorithm has linear complexity,
# then time/n should be approximately 1.0
timeNs = [round(time/n/avgTime,2) for n,time in measurements]
print(timeNs) # and it is, more or less
```

Grafické znázornění:

```python
import time
import matplotlib.pyplot as plt

def measureTime(f, n):
  begin = time.time()
  f(n)
  return time.time() - begin

def calcLinear(n:int):
  for _ in range(n):
    pass

def calcQuadratic(n:int):
  for _ in range(n):
    for _ in range(n):
      pass

ns = [n*10 for n in range(1,90)]

plt.plot(ns,[100*measureTime(calcLinear,n) for n in ns])
plt.plot(ns,[measureTime(calcQuadratic,n) for n in ns])
```

### Logaritmická složitost

Binární vyhledávání:

```python
def binSearch(data:list[int], val:int) -> int|bool:
  left = 0          # včetně
  right = len(data) # vyjma

  while left < right:
    middle = (left + right)//2
    midVal = data[middle]
    if val == midVal:
      return middle
    if val < midVal:
      right = middle
    else:
      left = middle

  return False

# test
data = [0, 1, 2, 8, 13, 17, 19, 32, 42] # musí být seřazená

for val in data + [-1]:
  print(val, 'nalezeno na pozici:', binSearch(data, val))
```

### Odmocninová složitost

Test na prvočíslo

```python
import math
def isPrime(p:int):
  if p<1:
    raise ValueError()
  if p<4:
    return True
  if 0==p%2:
    return False

  for factor in range(3, 1 + math.floor(math.sqrt(p)), 2):
    if 0==p%factor:
      return False

  return True

# test
from random import randint

for i in range(1,100):
  if isPrime(i):
    print(i, end=' ')

print()

for i in range(1_000_000_000,1_000_000_100):
  if isPrime(i):
    print(i, end=' ')
```

### Logaritmicko-lineární složitost / O(n log n)

Quicksort

```python
from random import randrange, shuffle

def qsort(lst:list) -> list:
  if len(lst) < 2:
    return lst

  pivot   = lst.pop(randrange(0, len(lst)))
  lesser  = [n for n in lst if n < pivot]
  greater = [n for n in lst if pivot <= n]

  return qsort(lesser) + [pivot] + qsort(greater)

# test
lst = list(range(10))
shuffle(lst)
print(lst)
print(qsort(lst))
```

## [PB13](https://github.com/pavelberanek91/UJEP/blob/main/APR1/Cvi%C4%8Den%C3%AD%213/README.md)

Zápočet nanečisto
