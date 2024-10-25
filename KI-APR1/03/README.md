# 03 – Debugging, rozhodování, cykly

[Proč se chybě v programu říká _bug_?](https://youtu.be/84VmwdGwYMA)

## Inspekce proměnných v zápisníku Google Colab

Inspekce proměnných = sledování jejich hodnoty a typu při běhu programu.

- Otevřete si postranní záložku _variables {x}_.
- Spusťte program v kódové buňce a sledujte vznik a obsah proměnných.
  Program pozastavíte pomocí (prázdným) `input()`.

```python
jméno = input('Jak se jmenujete? ')
bydliště = input('Kde bydlíte? ')
věk = int(input('Kolik je Vám let? '))

print(f'Dobrý den, pane/paní {jméno},')
print(f'bydlíte v městě {bydliště}')
věk = věk + 1
input() # pozastaveno
print(f'a za rok Vám bude {věk + 1} let.')
```

## Vestavěné funkce

Systémové funkce, metody a moduly mají v Pythonu jména, která začínají a končí dvěma podtržítky.
Např. modul `__builtins__` (tento modul nemusíme importovat) obsahuje vestavèné funkce, výjimky a jiné:

```python
print(__builtins__)
```

```python
dir(__builtins__)
```

```python
help(__builtins__) # ojojoj
```

Např. vestavěné funkce `min()` nebo `max()` ...

```python
help(min)
help(max)
```

... akceptují dva a více argumentů, nebo jeden seznam (list) hodnot:

```python
print(min(3,2))
print(min(3,2,4,8))

seznam = [3,2,4,8]
print(seznam)
print(type(seznam))
print(min(seznam))
```

## Řetězce (strings)

Řetězec ([str](https://docs.python.org/3/library/string.html)) je neměnná (immutable) posloupnost znaků.
Specielní (nestandardní) znaky lze zapisovat pomocí [escape sekvencí](https://www.w3schools.com/python/gloss_python_escape_characters.asp),
a to i [Unicode](https://docs.python.org/3/howto/unicode.html):

```python
s = 'line\n\talfa slon: \u03B1\U0001F418'
print(s)
```

Nebo můžeme vložit unicode přímo jako znak:

```python
slon = '🐘'
print(slon)
```

Řetězce lze spojovat,

```python
s = 'sss'
t = 'ttt'
s + t
```

opakovat,

```python
s = 'x '
n = 8
s * n
```

a hledat v nich podřetězce operátorem `in`:

```python
'ro' in 'Frodo'
```

```python
'ro' in 'Gandalf'
```

`str` rozeznává řadu metod:

```python
dir(str)
# help(str)
```

Například zaměňování:

```python
print('Faramir'.replace('Fara','Boro'))
```

nebo rozdělení řetězce na části:

```python
x,y,z = '3 4 5.0'.split() # Ha! Mnohonásobné přiřazení
print(x, y, z)
```

a mnohé další.

## Rozhodování – větvení programu

Podmínky – např. porovnání dvou čísel mají výsledek typu `bool`: `False` nebo `True`.
Ale i jiné typy lze použít jako tzv. pravdivostní hodnoty. Např.:

Čísla: 0 je nepravda, ostatní čísla pravda

```python
x = 0
# x = 0.0
# x = 0.1
# x = 1
print('není nula' if x else 'je nula')
```

Řetězce: prázdný řetězec je nepravda, neprázdný pravda

```python
s = ''
# s = '-'
# s = ' '
print('není prázdný' if s else 'je prázdný')
```

Seznamy: prázdný seznam je nepravda, neprázdný pravda

```python
l = []
# l = [0]
print('není prázdný' if l else 'je prázdný')
```

Podle podmínky lze program větvit na dva různé bloky. Vnitřek bloků musí být odsazený.
Typicky se v Pythonu odsazuje o čtyři mezery, ale v moderních editorech také jen o dvě mezery.

Větvení lze do sebe zanořovat:

```python
jméno = input('Jak se jmenujete? ')
věk = int(input('Kolik je Vám let? '))

AGE = 18
mladistvý = věk<AGE

if mladistvý:
  print('Dobrý den, mladý pane/slečno {jméno},')
  print('gratuluji k Vašemu mládí!')
else:
  print('Dobrý den, pane/paní {jméno},')
  print('gratuluji k Vaší moudrosti!')

if mladistvý:
  volba = input('Přejete si vodu? ')
else:
  volba = input('Přejete si vodu nebo vodku? ')

chciVodu = 'vodu' == volba

if mladistvý:
  if chciVodu:
    print('Zde je voda.')
  else:
    print('Zde je voda místo vodky.')
else:
  if chciVodu:
    print('Zde je voda.')
  else:
    print('Zde je vodka.')
```

Podmínky lze také řetězit:

```python
x = 0 # 1, -1
if x<0:
  print('x je záporné')
elif 0<x:
  print('x je kladné')
# elif ...
else:
  print('x je nula')
```

### 🟢 Úloha:

Napište program, který ze vstupu přečte koeficienty a, b, c kvadratické rovnice,
a to najednou, na jedné řádce, oddělené mezerami.
Program vypočítá a vypíše kořeny zadané rovnice.

## Cykly (smyčky) `for - in`

Program lze cyklit: opakovat jeho část. První druh je tzv. for-cyklus,
který provede kód (tělo cyklu) jednou pro každý zadaný objekt, tzv. _iteraci_:

```python
for i in range(6): # range() je líný "seznam"
  print(i)
```

`i` (nebo jiné jméno) je tzv. řídící proměnná cyklu

```python
for i in range(1,10,2): # lichá čísla
  print(i)
```

```python
for i in range(1,6):
  print('*' * i)
```

```python
for c in 'abc🐘': # znaky v řetězci
  print(c)
```

Řetězec (a podobné kolekce) lze indexovat (přistupovat k prvkům podle jejich pořadí, pozice):

```python
s = 'abc🐘'
for i in range(len(s)): # pozice (index) v řetězci
  print(s[i])           # znak na pozici i
```

A to i od konce, pomocí negativních indexů:

```python
s = 'abc🐘'
for i in range(len(s)): # pozice (indexy) v řetězci
  print(s[-i-1])           # znak na pozici i
```

Cykly lze do sebe vnořit:

```python
for i in range(6):      # vnější cyklus, řídicí proměnná i
  for j in range(8):    # vnitřní cyklus, řídicí proměnná j
    print('* ', end='')
  print()
```

Cyklus lze _předčasně_ ukončit příkazem `break`

```python
for i in range(10):
  if 7 < i: # končí se u šestky
    break
  print(i)
```

Také lze vynutit předčasné pokračování cyklu příkazem `continue`

```python
for i in range(10):
  if i % 2: # přeskoč lichá čísla
    continue
  print(i)
```

## Cykly `while`

Druhý typ cyklu je tzv. while-cyklus, který provádí kód (tělo cyklu) tak dlouho,
pokud je splněna daná podmínka:

```python
# stejné jako: for i in range(10):
i = 0         # počáteční hodnota
while i < 10: # podmínka
  print(i)    # tělo: první řádek
  i = i+1     # tělo: druhý řádek
```

Pozor na nekonečný cyklus!

```python
i = 0
while i < 10:
  print(i)
  i = i-1
```

Vstup a [obsluha výjimek](https://pythonbasics.org/try-except/):

```python
mámTo = False
while not mámTo:
  try:    # začátek chráněného bloku
    i = int(input('Zadej celé číslo mezi jednou a deseti: '))
    if 1 <= i <= 10:
      mámTo = True
  except: # zde se zachytí výjimka
    pass  # prázdný příkaz

print(f'zadáno bylo {i=}')
```

Nebo takto:

```python
while True:   # nekonečný cyklus
  try:        # chráněný blok
    i = int(input('Zadej celé číslo mezi jednou a deseti: '))
    if 1 <= i <= 10:
      break   # předčasné (explicitní) ukončení cyklu
  except:
    print('Chyba, chybka, chybička ⚠️')

print(f'zadáno bylo {i=}')
```

Tento kód je užitečný, můžeme z něj udělat funkci:

```python
def getInt(low, high):  # uživatelská funkce s paranetry low a high
  while True:
    try:
      number = int(input(f'Zadej celé číslo mezi {low} a {high}: '))
      if low <= number <= high:
        return number   # návrat z funkce
    except:
      pass

i = getInt(10, 20)
print(f'zadáno bylo {i=}')
j = getInt(20, 40)
print(f'zadáno bylo {j=}')
```

### 🟢 Úloha:

Napište program, který přečte ze vstupu slovo a vypíše každé druhé písmeno.

### 🟢 Úloha:

Napište program, který obsahuje v proměnné jméno nějaké osoby.
Program se vás zeptá na to, jak se osoba jmenuje.
Pokud napíšete správné jméno, tak vám program pogratuluje a skončí.
Pokud napíšete jméno špatně, tak se program zeptá znovu, tak dlouho,
dokud jméno neuhádnete.

### 🟢 Úloha:

Vnořené cykly: program přečte ze vstupu tři celá, nezáporná čísla, a vypíše obraz šachovnice, např.:

```
***   ***   ***   ***   ***
***   ***   ***   ***   ***
***   ***   ***   ***   ***
   ***   ***   ***   ***
   ***   ***   ***   ***
   ***   ***   ***   ***
***   ***   ***   ***   ***
***   ***   ***   ***   ***
***   ***   ***   ***   ***
```

kde tři zadané hodnoty jsou: počet řádků a sloupců šachovnice a velikost pole.

### 🟢 Úloha:

Upravte svoje programy z minulé lekce tak, aby byl vstup ošetřen proti uživatelské chybě.
Tj. když by v důsledku zadání chybné hodnoty došlo k výjimce, vypište chybové hlášení
a nechte uživatele zadat hodnotu znovu.

### 🟢 Úloha:

Napište program, ve uživatel zadá sadu čísel oddělených čárkou.
Následně ve druhém vstupu zvolí slovy jakou operaci chce s čísly provést:
např. `sečti`, `vynásob`, atd. nebo `+`, `*` atd.
Program podle výběru čísla sečte, vynásobí, atd.,
a vypíše výsledek.

### 🟢 Úloha:

Napište program, který zjistí, zda zadané slovo je palindrom, tedy čte se z obou stran stejně.
Např. "krk", "kunanesenanuk" nebo "jelenovipivonelej".

### 🟢 Úloha:

Napište program, který zjistí, zda zadané heslo uživatelem je tzv. silné.
Heslo musí obsahovat alespoň jedno velké písmeno, jedno malé písmeno, jednu číslici,
jeden speciální znak a minimální délka musí být alespoň 8 znaků.
(Nápověda: metody třídy `str`, začinající `is...`.)
