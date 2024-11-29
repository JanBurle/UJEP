# 10 – Řešení vybraných úloh

## [PB05](https://github.com/pavelberanek91/UJEP/blob/main/APR1/Cvi%C4%8Den%C3%AD%205/README.md)

### Překladový slovník

```python
slovníkCzAj = {
  'pes': 'dog',
  'na': 'on',
  'štěkal': 'barked',
  'pošťáka': 'postman',
}

def přelož(cz:str) -> str:
  return slovníkCzAj.get(cz,cz)

větaCz = 'Pes na kole jel a štěkal na pošťáka.'
větaCz = větaCz.lower().replace('.', '')

větaEn = ' '.join(map(přelož,větaCz.split()))
větaEn
```

### Hromadný předkladač\*\*

```python
slovníkCzAj = {
  'pes': 'dog', 'na': 'on', 'štěkal': 'barked', 'pošťáka': 'postman',
}

slovníkCzNj = {
  'pes': 'Hund', 'na': 'an', 'štěkal': 'bellte', 'pošťáka': 'Postmann',
}

slovníkCzFj = {
  'pes': 'koira', 'na': 'päällä', 'štěkal': 'hän haukkui', 'pošťáka': 'tarpeeksi',
}

slovníky = [
  slovníkCzAj, slovníkCzNj, slovníkCzFj
]

def přeložSlovo(slovník:dict, slovo:str) -> str:
  return slovník.get(slovo,slovo)

def přeložVětu(slovník:dict, věta:str) -> str:
  def přelož(slovo):
    return přeložSlovo(slovník, slovo)

  věta = věta.lower().replace('.', '')
  return ' '.join(map(přelož, věta.split()))


věta = 'Pes na kole jel a štěkal na pošťáka.'

for slovník in slovníky:
  print(přeložVětu(slovník, věta))
```

### Čítač slov

```python
import matplotlib.pyplot as plt

věta = 'Ahoj Jano. Jak se mas Jano. Mas se taky tak dobre jako ja Jano? Tak cau Jano!'
# nechat jen mezery a (malá) písmena
věta = ''.join(c.lower() for c in věta if c.isspace() or c.isalpha())

čítač = {}

for slovo in věta.split():
  if not slovo in čítač:
    čítač[slovo] = 0
  čítač[slovo] += 1

plt.bar(x=čítač.keys(), height=čítač.values())
```

### Čítač písmen

```python
import matplotlib.pyplot as plt

věta = 'Ahoj Jano. Jak se mas Jano. Mas se taky tak dobre jako ja Jano? Tak cau Jano'
věta = věta.lower()

čítač = {}
# naplnit
for c in 'abcdefghijklmnopqrstuvwxyz':
  čítač[c] = 0

for písmeno in věta:
    if písmeno in čítač:
        čítač[písmeno] += 1

plt.bar(x=čítač.keys(), height=čítač.values())
```

### Průměrná známka

```python
známky = {
    'Adam': [1,1,2,1,3,5],
    'Nela': [1,4,2,1],
    'Zuzi': [1,1,1,1,1,2,3,3],
}

def průměr(známky: dict[str,list[int]]) -> float:
  součet = 0
  počet  = 0

  for známkyŽáka in známky.values():
    součet += sum(známkyŽáka)
    počet  += len(známkyŽáka)

  return součet/počet

print(f'{průměr(známky):.2f}')
```

### Slovník s náhodným počtem klíčů

```python
from random import randint

slovník = {}

počet = randint(1,10)
for n in range(počet):
  klíč = f'klíč{n}'
  slovník[klíč] = [randint(0, 9) for _ in range(10)]

slovník
```

## [PB06](https://github.com/pavelberanek91/UJEP/blob/main/APR1/Cvi%C4%8Den%C3%AD%206/README.md)

### Která písmena jsou velká?

```python
def upperChars(s: str) -> list[str]:
  return [c for c in s if c.isupper()]

upperChars('Ahoj, jak se máš, Terezo? A Máša?')
```

### Vyhledání pozice slova

```python
def getIndex(lst:list, obj:any) -> bool|int:
  for i,elem in enumerate(lst):
    if obj==elem: return i
  return False # not found

getIndex(['g','f','a','f','h'], 'a')
```

### Řada lichých čísel

```python
def get_licha(min:int, max:int) -> list[int]:
  return list(range(min//2*2+1, max+1, 2))

get_licha(-4, 14)
```

### Pretty printer matic

```python
def ppMatrix(M: list[list[str]]):
  def p(s:str):
    print(s, end='')

  cols = len(M[0])
  print('┌' + '─' * (cols*4 -1 ) + '┐')
  for row in M:
    p('│ ')
    for i,col in enumerate(row):
      if 0<i: p(' : ')
      p(col)
    print(' │')
  print('└' + '─' * (cols*4 -1 ) + '┘')

M1 = [
  ['1', '2'],
  ['2', '3'],
  ['3', '4']
]

M2 = [
  ['X', 'O', 'O'],
  ['X', '_', '_'],
  ['_', 'X', '_']
]

M3 = [
  ['o',' ','o',' ','o'],
  [' ','o',' ','o',' '],
]

ppMatrix(M1)
ppMatrix(M2)
ppMatrix(M3)
```

### Nalezení písmen s háčky a čárkami

```python
def nalezniHáčkyČárky(s: str) -> list[str]:
  plain = 'abcdefghijklmnopqrstuvwxyz'
  result = []

  for c in s:
    if c.isalpha() and not c in plain:
      result.append(c)

  return result

nalezniHáčkyČárky("čau jak se máš")
```

```python
def nalezniHáčkyČárky(s: str) -> list[str]:
  plain = 'abcdefghijklmnopqrstuvwxyz'
  return [c for c in s if c.isalpha() and not c in plain]

nalezniHáčkyČárky("čau jak se máš")
```

### Všechna velká

```python
def getVelká(s:str) -> str:
  return s.upper()

getVelká("Ahoj")
```

```python
getVelká = lambda s : s.upper()
getVelká("Ahoj")
```

### Čísla beze zbytku

```python
def listMod(start=5, end=20, mod=5) -> list[int]:
  res = []
  for n in range(start, end+1):
    if 0 == n % mod:
      res.append(n)

  return res

listMod()
```

```python
def listMod(start=5, end=20, mod=5) -> list[int]:
  return [n for n in range(start, end+1) if 0 == n % mod]

listMod()
```

### Počet výskytů

```python
def početVýskytů(s:str, c:str) -> int:
  cnt = 0
  for char in s:
    if char==c:
      cnt += 1

  return cnt

početVýskytů('aha hmm', 'h')
```

```python
def početVýskytů(s:str, c:str) -> int:
  return len([char for char in s if char==c])

početVýskytů('aha hmm', 'h')
```

```python
def početVýskytů(s:str, c:str) -> int:
  return sum([1 for char in s if char==c])

početVýskytů('aha hmm', 'h')
```

```python
def početVýskytů(s:str, c:str) -> int:
  return sum(map(lambda x : 1 if x==c else 0, list(s)))

početVýskytů('aha hmm', 'h')
```

### Každé druhé

```python
'ahojpepo'[1::2]
```

### Smazání písmenka

```python
list('ahoj'.replace('o',''))
```

### Spojení seznamů

```python
def spoj(l1:list, l2:list) -> list:
  res = []
  for i in range(len(l1)):
    res.append(l1[i])
    res.append(l2[i])

  return res

spoj([1,2,3],['a','b','c'])
```

```python
def spoj(l1: list, l2: list) -> list:
    return [item for pair in zip(l1, l2) for item in pair]

spoj([1, 2, 3], ['a', 'b', 'c'])
```

### Skalární součin

```python
def dotProduct(l1:list[int], l2:list[int]) -> int:
  prod = 0
  for i in range(len(l1)):
    prod += l1[i] * l2[i]

  return prod

dotProduct([1,2,3],[2,3,4])
```

```python
def dotProduct(l1:list[int], l2:list[int]) -> int:
  return sum(pair[0]*pair[1] for pair in zip(l1,l2))

dotProduct([1,2,3],[2,3,4])
```

### Náhodný seznam

```python
from random import uniform

def randList(n:int, a:float, b:float) -> list[float]:
  res = []
  for i in range(n):
    res.append(uniform(a,b))

  return res

randList(4,2.0,2.4)
```

```python
from random import uniform

def randList(n:int, a:float, b:float) -> list[float]:
  res = [0]*n
  for i in range(n):
    res[i] = uniform(a,b)

  return res

randList(4,2.0,2.4)
```

```python
from random import uniform

def randList(n:int, a:float, b:float) -> list[float]:
  return [uniform(a,b) for _ in range(n)]

randList(4,2.0,2.4)
```

### Promíchání písmenek

```python
from random import shuffle

def shuffled(lst: list[str]) -> list[str]:
  lst = lst.copy() # or: lst = lst[:]
  shuffle(lst)
  return lst

shuffled(list('abcdef'))
```

```python
from random import sample

def shuffled(lst: list[str]) -> list[str]:
  return sample(lst, len(lst))

shuffled(list('abcdef'))
```

### Zašifrování a dešifrování textu

```python
encoder = {
  'a': 'j',
  'o': 'k'
}

decoder = {value: key for key,value in encoder.items()}

def encode(s: str) -> str:
  enc = lambda c: encoder.get(c, c)
  return ''.join(map(enc,list(s)))

def decode(s: str) -> str:
  dec = lambda c: decoder.get(c, c)
  return ''.join(map(dec,list(s)))

print(encode('ahoj'))
print(decode('jhkj'))
```

## [PB07](https://github.com/pavelberanek91/UJEP/blob/main/APR1/Cvi%C4%8Den%C3%AD%207/README.md)

### Výpočet Ludolfova čísla metodou Monte Carlo

1. Kružnice o jednotkovém poloměru se nachází uvnitř čtverce.
2. Program opakovaně náhodně střílí do čtverce a počítá, kolikrát se trefil do kružnice.
3. Podíl zásahů aproximuje π.

```python
from random import uniform
from math import sqrt

def circleShot() -> bool:
  x = uniform(-1, +1)
  y = uniform(-1, +1)
  return x*x + y*y <= 1 # no need for sqrt()

hits = 0
for i in range(1,1_000_000):
  if circleShot(): hits += 1
  if 0 == i % 100_000:
    print(i, 4*hits/i)
```

## [PB08](https://github.com/pavelberanek91/UJEP/blob/main/APR1/Cvi%C4%8Den%C3%AD%208/README.md)

Funkcionální programování

### Komprehenze / generátorové výrazy

Tři části:

- výraz transformuje prvky
- `for` cyklus generuje prvky
- podmínka (nepovinná) filtruje prvky

Seznamy:

```python
[i for i in range(10)]
```

```python
[i*2 for i in range(10)]
```

```python
[i for i in range(10) if i%3]
```

Množiny:

```python
{i for i in range(10)}
```

Slovníky:

```python
{i:str(i*2) for i in range(10)}
```

Vnořené komprehenze:

```python
# 3x4 matrix
[[i*10+j for j in range(1,5)] for i in range(1,4)]
```

### map

`map` transformuje data (iterovatelný) objekt pomocí dané funkce na nový iterovatelný objekt, kde každý nový prvek je výsledek aplikace funkce na původní prvek.

```python
from math import sqrt
list(map(sqrt, [0,1,4,9]))
```

```python
def add10(x):
  return 10 + x
list(map(add10, [i for i in range(10)]))
```

### zip

`zip` spojí dané kolekce do iterovatelného objektu n-tic:

```python
list(zip([1,2,3,4],['a','b','c','d']))
```

```python
list(zip([1,2,3,4],['a','b','c','d'],[10,20,30,40]))
```

### filter

`filter` filtruje kolekci pomocí funkce. Pouze prvky, pro které je výsledek funkce pravdivý, budou v nové kolekci.

```python
def isShort(s:str) -> bool:
  return len(s) < 2

list(filter(isShort, ['a','aa','bc','b','ddd','q']))
```

Pomocí lambda (anonymní, bezejmenné) funkce:

```python
list(filter(lambda s: len(s)<2, ['a','aa','bc','b','ddd','q']))
```

### Náhodná čísla komprehenzí

Seznam naplněný náhodnými hodnotami od 5 do 10.

```python
from random import randint
lst = [randint(5,11) for _ in range(9)]
list(lst)
```

### Náhodná písmena komprehenzí

Seznam naplněný náhodnými hodnotami od 'a' do 'z'.

```python
from string import ascii_lowercase
from random import choice

list([choice(ascii_lowercase) for _ in range(9)])
```

### Komprehenze se vstupem uživatele

Seznam naplněný řetězci ze vstupu příkazem input().

```python
list([input(f'{i}> ') for i in range(3)])
```

### Lichá čísla komprehenzí

Seznam lichých čísel.

```python
list([i*2+1 for i in range(5)])
```

### Velká abeceda bez samohlásek

Seznam slov z věty, slova budou vypsána velkou abecedou, bez samohlásek [a,e,i,o,u,y].

```python
sentence = 'How much wood would a woodchuck chuck?'

def mapWord(word):
  return ''.join(filter(lambda c: not c in 'AEIOU',list(word.upper())))

list(map(mapWord, sentence.split()))
```

### Mapování kladných

Algoritmus převezme matici a vrátí seznam pravdivostních hodnot, kde pravdivostní hodnota představuje, zda v daném řádku jsou všechny prvky kladné.

```python
# matrix
M = [[i*10+j for j in range(-20,-15)] for i in range(1,4)]
print(M)

def allPositive(lst:list) -> bool:
  return all(0 < e for e in lst)

list(map(allPositive,M))
```

### Mapování na délku řetězců

Algoritmus s využitím map, který převezme řetězec a vrátí seznam délek slov v řetězci.

```python
s = 'How much wood would a woodchuck chuck?'
list(map(len,s.split()))
```

### Mapování s filtrací

Algoritmus převezme seznam čísel, odstraní všechny kladná a vrátí seznam absolutních hodnot zbylých čísel.

```python
lst = [1, -3, -8, 7, 4, -4, 5, -3, 1, -9]
lst = list(map(lambda x:-x, filter(lambda x:x<=0, lst)))
lst
```

### Pořadí písmen

Algoritmus s využitím zip převezme seznam písmen a vrátí seznam dvojic (číslo, písmeno), kde číslo představuje pořadí písmena v abecedě. Využijte string.ascii_lowercase.

```python
from string import ascii_lowercase
from random import choice

alw = ascii_lowercase

letters = [choice(alw) for _ in range(9)]
numbers = map(lambda c:alw.index(c)+1, letters)

list(zip(numbers, letters))
```

### Rozdělení seznamu

Algoritmus pomocí funkce zip rozdělí seznam trojic na tři seznamy.

```python
lst = [(1,'a',False), (2,'b',False), (3,'c',True), (4,'d',False)]
list(zip(*lst))
```

### Součin trojic

Napište algoritmus, který přijme seznam trojic a vrátí seznam, obsahující součiny prvků ve trojicích.

```python
lst = [(1,1,2), (2,-2,1), (3,0,3), (3,3,3)]

import math
list(map(math.prod, lst))
```

### Skalární součin lambdou

Napište anonymní funkci, která vrátí skalární součin dvou vektorů, které jsou argumentem.

```python
lst1 = [2,3,4]
lst2 = [3,4,1]

import math
(lambda l1,l2: sum(map(math.prod,zip(l1,l2))))(lst1,lst2)
```

### Odstranění malých písmen lambdou

Anonymní pomocí funkce filtr odstraní z řetězu všechny prvky, které nejsou velkým písmenem.

```python
velká = lambda s: ''.join(filter(lambda c: c.isupper(), list(s)))
velká('abCDe. ')
```

### Obrácení pořadí lambdou

Anonymní funkce pomocí map obrací pořadí seznamů. Do funkce přijde matice, kde řádky jsou seznamy, které budou anonymní funkcí obráceny.

```python
obrať = lambda M: list(map(lambda lst:list(reversed(lst)), M))
obrať([[1,2,3],[4,1,2,3]])
```

### Fibonacciho posloupnost

Vytvořte pomocí anonymní funkce Fibonacciho posloupnost.

```python
from functools import reduce
fibonacci = lambda n: reduce(lambda sq, _: sq + [sq[-1] + sq[-2]], range(2, n), [0, 1])

fibonacci(8)
```
