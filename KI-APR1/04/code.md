# Ukázková řešení úloh

#### Sestavte program, který vypočítá a vypíše pravdivostní tabulky logických operací:

```python
print('and')
for a in [False, True]:
  for b in [False, True]:
    print(a, b, a and b)

print()
print('or')
for a in [False, True]:
  for b in [False, True]:
    print(a, b, a and b)

print()
print('not')
for a in [False, True]:
  print(a, not a)
```

Pro tři vstupní hodnoty, lépe formátovaný výstup:

```python
def ft(v):
  """ vrátí 'T' když v je tru-ish, jinak 'F'"""
  return 'T' if v else 'F'

print('** and **')
for a in [False, True]:
  for b in [False, True]:
    for c in [False, True]:
      print(ft(a), ft(b), ft(c), '|', ft(a and b and c))
```

A ještě lépe pommocí znaků na [kreslení rámečků](https://en.wikipedia.org/wiki/Box-drawing_characters):

```python
def ft(v):
  return 'T' if v else 'F'

print('┌───────────┐')
print('│    and    │')
print('├───────────┤')

for a in [False, True]:
  for b in [False, True]:
    for c in [False, True]:
      print('│', ft(a), ft(b), ft(c), '>', ft(a and b and c), '│')

print('└───────────┘')

# Úloha: Rámečky jsou zde "zakódované natvrdo" (hard-coded).
# Bylo by je možné parametrizovat, tj. vypočítat podle počtu vstupních hodnot,
# tedy potřebné šířky rámečku?
```

---

#### Prověřte pomocí kódu, že De Morganova pravidla platí:

Např. pro tři proměnné:

```python
def ft(v):
  return 'T' if v else 'F'

for a in [False, True]:
  for b in [False, True]:
    for c in [False, True]:
      print(ft(not(a and b and c)), '=', ft(not a or not b or not c), end='')
      print(' / ', end='')
      print(ft(not(a or b or c)), '=', ft(not a and not b and not c))
```

---

#### Napište program na rozpoznání palindromu:

```python
def onlyAlpha(s):
  """ Ponechá jen písmena. """
  s2 = ''
  for c in s:
    if c.isalpha():
      s2 += c

  return s2

def shortenVowels(s):
  """ Předpokládá malá písmena, zkrátí samohlásky. """
  t1 = 'áéíóúůýö' # tyto nahradí
  t2 = 'aeiouuyo' # těmito
  for i in range(len(t1)):
    s = s.replace(t1[i],t2[i])

  return s

def isReversible(s):
  """ Je s stejný i po obrácení? """
  for i in range(len(s)//2): # stačí jít do poloviny
    if s[i] != s[-i-1]:      # pokud písmeno počítané od začátku je jiné než od konce
      return False           # předčasný návrat
  return True                # předčasný návrat nenastal, s je reverzibilní

# vstup, konverze na malá písmena
s = input('Věta: ').lower()

isPali = isReversible(shortenVowels(onlyAlpha(s)))

print(isPali)

# Úloha k zamyšlení:

# isReversible() zjišťuje, zda je řetězec po obrácení stejný,
# pomocí tzv. "in-place" algoritmu, tj. bez nutnosti vytvářet kopie
# dat, jak tomu je např. při použití výrazu s==s[::-1].

# Bylo by možné napsat celý program na rozeznání palindromu
# aniž by se vytvářely jakékoli kopie vstupního řetězce,
# jako to zde dělají funkce onlyAlpha() a shortenVowels() ?
```
