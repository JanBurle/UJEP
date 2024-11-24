# 09 – Řešení vybraných úloh

## [PB01](https://github.com/pavelberanek91/UJEP/blob/main/APR1/Cvi%C4%8Den%C3%AD%201/README.md)

### 📐 Detekce pravoúhlého trojúhelníku

Zjistěte, zda je zadaný trojúhelník pravoúhlý. Délky stran trojúhelníka jsou zadány v řetězci, najednou v libovolném pořadí, oddělené mezerou.

```
vstup  = '4 5 3'
# vstup = input('Zadejte tři strany: ')

strany = list(map(float,vstup.split()))
přepona = max(strany)
strany.remove(přepona)
odvěsna1, odvěsna2 = strany

from math import isclose
jePravouhly = isclose(přepona**2, odvěsna1**2 + odvěsna2**2)

jePravouhly
```

### 📱 Kalkulačka

Program se zeptá na dvě desetinná čísla a vypočítá jejich součet, rozdíl, součin a podíl. Tyto operace proveďte při výpisu v interpolačním řetězci.

```python
vstup = input('Zadejte dvě čísla oddělená mezerou: ')
a,b = map(float,vstup.split())
print(f'{a+b=}, {a-b=}, {a*b=}, {a/b=}')
```

### 📱 Objem kvádru

Program se zeptá na 3 hodnoty oddělené čárkou. Program tyto hodnoty separuje do proměnných, provede jejich přetypování a vypíše objem kvádru.

```python
vstup = input('Zadejte strany kvádru oddělené čárkou: ')
a,b,c = map(float,vstup.split(','))
print(f'Objem = {a*b*c}')
```

## [PB02](https://github.com/pavelberanek91/UJEP/blob/main/APR1/Cvi%C4%8Den%C3%AD%202/README.md)

### ❓ Řešitel kvadratických rovnic

Program přijme najednou koeficienty kvadratické rovnice oddělené mezerou. Vypočítá a vypíše kořeny této rovnice.

```python
def solveQuadraticEquation(a:float, b:float, c:float) -> None|float|tuple[float,float]:
  D = b*b - 4*a*c

  if D < 0:
    return None

  if 0 < D:
    sqrtD = D ** .5
    x1 = (-b + sqrtD) / (2*a)
    x2 = (-b - sqrtD) / (2*a)
    return (x1, x2)

  # here: D==0
  return -b / (2*a)

a,b,c = map(float, input('Zadej a,b,c oddělené mezerou: ').split())
roots = solveQuadraticEquation(a, b, c)
print(f'Kořeny: {roots}')
```

### 🤖 Jednokolová verze kámen-nůžky-papír

Program realizuje jedno kolo hry kámen-nůžky-papír. Hráč volí mezi třemi symboly (kámen, nůžky, papír) pomocí standardního vstupu. Protihráčem je umělá inteligence, která vybírá symboly náhodně. Vypište informaci o tom, kdo si co vybral a jak kolo hry dopadlo.

```python
možnosti = ['kámen', 'nůžky', 'papír']

# hráč
volba = ''
while not volba in možnosti:
  volba = input('kámen, nůžky, papír? ').strip()

idxVolba = možnosti.index(volba)

# počítač
from random import randint

idxProti = randint(0,2)
proti = možnosti[idxProti]

# výsledek
print('Vy:', volba)
print('Já:', proti)

if volba==proti:
  print('plichta')
else:
  výhry = [(0,1),(1,2),(2,0)]
  if (idxVolba,idxProti) in výhry:
    print('Vyhrál jste.')
  else:
    print('Vyhrál jsem.')
```

### 🌟 Sportka

Program generuje číslo výherního losu od 1 do 9. Uživatel zadá číslo svého losu a program vypíše zprávu o výsledku.

```python
from random import randint
tah = randint(1,9)

los = int(input('Váš los (1-9): '))
print('Vyhrál jste.' if tah==los else 'Možná příště.')
print(f'(Bylo taženo {tah})')
```

### 😬 Silné heslo

Program zjistí, zda zadané heslo uživatelem je silné: musí mít alespoň jedno velké písmeno, jedno malé písmeno, jednu číslici, jeden speciální znak a minimální délka musí být alespoň 8 znaků.

```python
def isStrong(pwd: str) -> bool:
  if pwd != pwd.replace(' ',''):
    return False # no spaces allowed

  if len(pwd) < 8:
    return False # too short

  hasUpper   = False
  hasLower   = False
  hasDigit   = False
  hasSpecial = False

  for c in pwd:
    if c.isalpha():
      if c==c.upper():
        hasUpper = True
      else:
        hasLower = True
    elif c.isdigit():
      hasDigit = True
    else:
      hasSpecial = True

  return hasUpper and hasLower and hasDigit and hasSpecial

# test
pwds = ['heslo', '12345678', 'aA.8////', 'aA.8/// /']

for pwd in pwds:
   print(pwd, isStrong(pwd))
```

### 🌀 Trefa do kulatého terče

Program náhodně vystřelí do čtverce. Ve čtverci je umístěna kružnice (terč) s daným středem a poloměrem. Program zahlásí trefu, pokud souřadnice náhodného výstřelu jsou uvnitř terče.

```python
# souřadnice čtverce
x1 = -10.
x2 = +10.
y1 = -10.
y2 = +10.

# souřadnice kruhu: střed a poloměr
kx = 0.
ky = 0.
kr = 5.

from random import uniform
def střela() -> tuple[float,float]:
  x = uniform(x1,x2)
  y = uniform(y1,y2)
  return (x,y)

from math import sqrt
def jeVKruhu(xy: tuple[float,float]) -> bool:
   x,y = xy
   r = sqrt((kx-x)**2 + (ky-y)**2)
   return r < kr

# test
zásah = False
while not zásah:
   pokus = střela()
   zásah = jeVKruhu(pokus)
   print('{:+.1f} {:+.1f}'.format(*pokus), '-', 'ano' if zásah else 'ne')
```

### 🥳 Narozeniny

Napište program, do kterého zadáte datum vašeho narození. Program se podívá na dnešní datum pomocí knihovny datetime a vypíše, kolik zbývá dnu do vašich narozenin. Pokud máte narozeniny dnes, tak vám navíc ještě pogratuluje.

```python
from datetime import date

# day of birth
day, month, year = map(int, input('Zadejte datum - den.měsíc.rok: ').split('.'))
dob = date(year, month, day)

# today
today = date.today()

# birthday this year
birthday = date(today.year, dob.month, dob.day)

if (birthday - today).days < 0:
  # birthday next year
  birthday = date(today.year + 1, dob.month, dob.day)

remainDays = (birthday - today).days
if 0 < remainDays:
  print('Dní do narozenin:', remainDays)
else:
  print('Vše nejlepší!')
```

## [PB03](https://github.com/pavelberanek91/UJEP/blob/main/APR1/Cvi%C4%8Den%C3%AD%203/README.md)

### 🤖 Kámen-nůžky-papír na dvě vítězná kola

Upravte předchozí kód na verzi hry, ve které vyhrává hráč nebo počítač až po dvou vítězných kolech.

```python
def kolo() -> tuple[int,int]:
  from random import randint

  možnosti = ['kámen', 'nůžky', 'papír']

  volba = ''
  while not volba in možnosti:
    volba = input('kámen, nůžky, papír? ').strip()

  idxVolba = možnosti.index(volba)

  idxProti = randint(0,2)
  proti = možnosti[idxProti]
  print('Robot:', proti)
  if volba==proti:
    return (0,0)

  return  (1,0) if (idxVolba,idxProti) in výhry else (0,1)

výhryČlověk = 0
výhryRobot  = 0

while výhryČlověk<2 and výhryRobot<2:
  vč, vr = kolo()
  výhryČlověk += vč
  výhryRobot  += vr
  print('Skóre člověk/robot: ', výhryČlověk, '/', výhryRobot)
```

### 🔟 Zadání čísla

Napište program, který neskončí dokud uživatel nezadá číslo, které po přetypování nevyhodí chybu.

```python
while True:
  try:
    celéČíslo = int(input('Zadej celé číslo: '))
    break
  except:
    print('Chyba, chybka, chybička ⚠️')

print(f'Zadáno bylo jest číslo {celéČíslo}.')
```

### 🧮 Průměr ze zadaných dat

Program žádá uživatele o zadávání číselných dat do té doby, dokud uživatel nenapíše řetězec STOP. Poté vypíše na obrazovku aritmetický průměr z hodnot. Přidávání do kolekce se provádí příkazem append.

```python
čísla = []

while True:
  vstup = input('Zadej číslo nebo STOP: ').strip()
  if 'STOP'==vstup:
    break
  try:
    čísla.append(float(vstup))
  except:
    print('Chyba, chybka, chybička ⚠️')

if čísla:
  print('Průměr: ', sum(čísla)/len(čísla))
else:
  print('Nemám čísla.')
```

### 🧮 Statistika

Do předchozího programu naimportujte knihovnu statistics. Tato knihovna obsahuje různé užitečné statistické vzorce. Po nasbírání dat vypište pomocí této knihovny statistické hodnoty ...

```python
def čtiČíslo() -> float:
  while True:
    vstup = input('Zadej číslo nebo STOP: ').strip()
    if 'STOP'==vstup:
      raise UserWarning()
    try:
      return float(vstup)
    except:
      print('Chyba, chybka, chybička ⚠️')

čísla = []
while True:
  try:
    čísla.append(čtiČíslo())
  except UserWarning:
    break

if čísla:
  import statistics
  print('Průměr: ', statistics.mean(čísla))
else:
  print('Nemám čísla.')
```

### 🤷 Losovač otázek

Program obsahuje seznam otázek. Spustí se cyklus, který se opakuje do té doby, dokud v seznamu zbývají otázky. Kdykoliv uživatel zmáčkně klávesu ENTER, tak program jednu z otázek náhodně vylosuje a vypíše na obrazovku. Otázky jsou voleny náhodně.

```python
questions = [
  'Question 1',
  'Question 2',
  'Question 3',
  'Question 4',
  'Question 5',
]

from random import randint

while questions:
  input('losujeme ...')
  i = randint(0, len(questions)-1)
  print(questions.pop(i))

print('A to je vše.')
```

### 🐚 Fibonacciho posloupnost

Vypočítejte Fibonacciho posloupnost do hodnoty zadané uživatelem.

```python
n = int(input('n: '))

a,b = 0,1
for _ in range(n):
  print(a, end=' ')
  a,b = b,a+b
```

### 🦁 Rovnice lovec-kořist

Realizujte Lotka-Volterra model pro lovce a kořist.

```
# https://en.wikipedia.org/wiki/Lotka%E2%80%93Volterra_equations
# https://www.cs.unm.edu/~forrest/classes/cs365/lectures/Lotka-Volterra.pdf

# dx/dt = Ax - Bxy
# dy/dt = -Cy + Dxy

A = 3.0299
B = 4.0941
C = 1.9672
D = 2.2959

x = 1
y = 1
dt = .01

def next():
  global x, y
  x += ( A*x - B*x*y) * dt
  y += (-C*y + D*x*y) * dt

xs = []
ys = []
ts = []

for i in range(800):
  xs.append(x)
  ys.append(y)
  ts.append(i*dt)
  next()

import matplotlib.pyplot as plt

plt.title("predator-prey")
plt.ylabel("Population")
plt.xlabel("Time")
plt.plot(ts, xs, "b-")
plt.plot(ts, ys, "r-")
plt.show()
```

## [PB04](https://github.com/pavelberanek91/UJEP/blob/main/APR1/Cvi%C4%8Den%C3%AD%204/README.md)

### 🧺 Nákupní košík

Mějme seznam zboží s cenou. Uživatel napíše název produktu a množství, které chce zakoupit. Až uživatel napíše ZAPLATIT, tak program ukončí zadávání zboží do košíku a vypíše na obrazovku celkovou cenu za nákup.

```
# dictionary / slovník
sortiment = {
  'banán': 10,
  'rohlík': 3,
  'paštika': 30,
  'hermelín': 50,
  'chleba': 30,
  'salám': 60,
  'kečup': 70,
  'eidam': 40,
  'mandarinka': 8,
  'okurka': 10,
}

item = ''
amount = 0
basket = []

while True:
  inp = input('Zadejte zboží a množství nebo ZAPLATIT: ').strip()
  if 'ZAPLATIT'==inp:
    break

  try:
    item, strAmount = inp.split()
    amount = int(strAmount)
  except:
    continue

  if item in sortiment and 0 < amount:
    print(item, amount)
    basket.append((item, amount))

if basket:
  sum = 0
  for item,amount in basket:
    itemPrice = sortiment[item]
    price = itemPrice * amount
    sum += price
    print(f'{item:10s} {itemPrice:2} * {amount:3} ks = {price:4}')

  print(f'Celkem:                {sum:6}')

else:
  print('Přijďte jindy.')
```

### 🎓 Skupiny

Uživatel zadá seznam studentů a počet skupin, na které chce studenty rozdělit. Program vytvoří seznam n-tic studentů o pokud možno stejné velikosti.

```python
# set of students
students = set()

for student in input('Zadej jména studentů oddělená čárkou: ').split(','):
  if student:
    students.add(student)

numGroups = int(input('Počet skupin: '))
assert 0 < numGroups

# list of lists
groups = []
for _ in range(numGroups):
  groups.append([])

# distribute students into groups
while students:
  for group in groups:
    if students:
      group.append(students.pop())

# convert to list of tuples
groups = list(map(tuple, groups))
groups
```

### 🖼️ Šum

Program vytvoří obrázek složený z náhodných hodnot v odstinech šedi (šum). Vizualizujte knihovnou PIL.

```python
from PIL import Image
from random import randint

size = (120,90)
img = Image.new('RGB', size)

for w in range(img.width):
  for h in range(img.height):
    g = randint(0,255)
    img.putpixel((w,h), (g,g,g))

display(img)
```

### 🎓 Studenti a zapsané kurzy

Mějme seznamy studentů, kteří chodí na příslušný předmět.

Použijte množinové operace a zjistěte následující:

1. Kolik studentů celkem studuje APR1 nebo IKT (dohromady)
2. Kolik studentů studuje APR1, ale nestuduje IKT
3. Kolik studentů studuje APR1 a zároveň studuje IKT
4. Kolik studentů nestuduje ani jeden z předmětů
5. Zjistěte pomocí množinové operace, zda APR1 obsahuje všechny studenty z IKT

```
# lists
studenti = ["Pavel Beránek", "Jana Novotná", "Jan Hřib", "Vítězslav Nezval", "Petr Slavný", "Milan Balog", "Alena Jakubská"]
apr1 = ["Pavel Beránek", "Jana Novotná", "Petr Slavný", "Milan Balog", "Alena Jakubská"]
ikt = ["Pavel Beránek", "Petr Slavný", "Alena Jakubská"]

# covert to sets
studenti = set(studenti)
apr1 = set(apr1)
ikt = set(ikt)

def out(text:str, val:set):
  print(text + ':', len(val), '=', val)

out('APR1 nebo IKT', apr1.union(ikt))
out('APR1 ale ne IKT', apr1.difference(ikt))
out('APR1 a IKT', apr1.intersection(ikt))
out('ani APR1 ani IKT', studenti.difference(apr1,ikt))
```

### 🖹 Zadaná písmenka

Program, přijme ze standardního vstupu různá slova. Vstup skončí jakmile uživatel napíše slovo STOP. Vypíše se seznam písmenek bez duplicit, která všechny slova obsahovala. K smazaní duplicit využijte množinu.

```python
words = set()
chars = set()

while True:
  word = input('Slovo> ').strip()
  if 'STOP'==word:
    break
  for char in word.lower():
    chars.add(char)

sorted(chars)
```

### 🟧 Piškvorky

Naprogramujte podle PB zadání.

### ♟️ Člověče nezlob se

Naprogramujte podle PB zadání.

### 🃏 Pexeso

Naprogramujte podle PB zadání.

### ⛗ Nejkratší cesta

Mějme seznam měst a jejich vzdáleností. Nalezněte nejkratší cestu od startovního do cílového města.

https://www.geeksforgeeks.org/shortest-path-algorithms-a-complete-guide/

```python
start_mesto = "Chabařovice"
cilove_mesto = "Litoměřice"
vzdálenosti = [
  ("Chabařovice", "Ústí nad Labem", 8),
  ("Chabařovice", "Krupka", 1),
  ("Krupka", "Teplice", 1),
  ("Teplice", "Ústí nad Labem", 3),
  ("Teplice", "Litoměřice", 5),
  ("Ústí nad Labem", "Litoměřice", 10),
]
```
