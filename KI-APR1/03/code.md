# Ukázková řešení úloh

#### Napište program, který ze vstupu přečte koeficienty a, b, c kvadratické rovnice, a to najednou, na jedné řádce, oddělené mezerami. Program vypočítá a vypíše kořeny zadané rovnice.

```python
a,b,c = input('Zadej a,b,c').split(',')

a = float(a)
b = float(b)
c = float(c)

# nebo:
# abc = input('Zadej a,b,c').split(',')
# a,b,c = map(float, abc)

D = b*b - 4*a*c

if 0 <= D:
  sqrtD = D ** .5
  x1 = (-b + sqrtD) / (2*a)
  x2 = (-b - sqrtD) / (2*a)
  if x1 == x2:
    print(f'Řešení je: {x1=:.3g}.')
  else:
    print(f'Řešení jsou: {x1=:.3g}, {x2=:.3g}.')
else:
  print('Nemá řešení.')
```

---

#### Napište program, který přečte ze vstupu slovo a vypíše každé druhé písmeno.

```python
s = input('Slovo: ')
for i in range(len(s)):
  if i%2:
    print(s[i], end='')
```

Nebo:

```python
s = input('Slovo: ').strip()
print(s[1::2])
```

---

#### Napište program, který obsahuje v proměnné jméno nějaké osoby. Program se vás zeptá na to, jak se osoba jmenuje. Pokud napíšete správné jméno, tak vám program pogratuluje a skončí. Pokud napíšete jméno špatně, tak se program zeptá znovu, tak dlouho, dokud jméno neuhádnete.

```python
osoba = 'Tom'
pokus = ''
while pokus.lower() != osoba.lower(): # ignoruj velká/malá písmena
  pokus = input('Hádej: ').strip()
print('Výborně!')
```

---

#### Vnořené cykly: zadáme tři celá, nezáporná čísla. Program vypíše obraz šachovnice.

Jedno z **mnoha** moźných řešení:

```python
rows = 3 # počet řádků
cols = 5 # počet sloupců
size = 2 # velikost pole

for r in range(rows*size):
  oddR = r % (2*size) < size            # lichý řádek
  for s in range(cols*size):
    oddS = s % (2*size) < size          # lichý sloupec
    char = '-' if oddR ^ oddS else '*'  # ^: logická operace 'xor'
    print(char, end='')
  print()
```

---

#### Napište program, který zjistí, zda zadané heslo uživatelem je tzv. silné. Heslo musí obsahovat alespoň jedno velké písmeno, jedno malé písmeno, jednu číslici, jeden speciální znak a minimální délka musí být alespoň 8 znaků. (Nápověda: metody třídy `str`, začinající `is...`.)

```python
pwd = input('Heslo: ')

# výchozí hodnoty
hasSpace = False  # mezery apod.
hasLower = False  # malé písmeno
hasUpper = False  # velké písmeno
hasDigit = False  # číslice
hasSpec  = False  # speciální (nikoli alfannumerický) znak

isLongEnough = 8 <= len(pwd)

for char in pwd:
  if char.isspace():
    hasSpace = True
  elif char.islower():
    hasLower = True
  elif char.isupper():
    hasUpper = True
  elif char.isdigit():
    hasDigit = True
  else:
    hasSpec = True

isValid = isLongEnough and not hasSpace and hasLower and hasUpper and hasDigit and hasSpec

print('platné' if isValid else 'neplatné', 'heslo')

if not isLongEnough:
  print('krátké heslo')

if hasSpace:
 print('nesmí mít mezery')

if not hasLower:
  print('musí mít malé písmeno')

if not hasUpper:
  print('musí mít velké písmeno')

if not hasDigit:
  print('musí mít číslici')

if not hasSpec:
  print('musí mít speciální znak')
```

---

#### Napište program, který zjistí, zda zadané slovo je palindrom, tedy čte se z obou stran stejně.

Bylo řešeno na přednášce.
