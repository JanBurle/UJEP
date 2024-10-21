# Ukázková řešení úloh

Jeden problém – více možných algoritmů.
Jeden algoritmus – řada možných realizací programem.

#### Napište program, který se uživatele zeptá na jméno, věk, bydliště (atd.) a pak vypíše text: Dobrý den, ..., Vaším domovem je ... a za rok Vám bude ... let.

```python
jméno    = input('Jak se jmenujete? ')      # type: str
bydliště = input('Kde bydlíte? ')           # str
věk      = int(input('Kolik je Vám let? ')) # int

print(f'Dobrý den, pane/paní {jméno},')
print(f'bydlíte v městě {bydliště}')
print(f'a za rok Vám bude {věk + 1} let.')
```

---

#### Zadejte délku odvěsen pravoúhlého trojúhelníku a vypište délku přepony.

```python
a = float(input('Zadejte délku první odvèsny: ')) # float
b = float(input('Zadejte délku druhé odvèsny: ')) # float

import math
c = math.sqrt(a*a + b*b) # float

print(f'Délka přepony pravúhlého trojúhelníku je {c:.2f}.')
```

---

#### Zadejte délku stran trojúhelníku a určete, zda je trojúhelník pravoúhlý.

```python
x = float(input('Zadejte délku první strany: ')) # float
y = float(input('Zadejte délku druhé strany: ')) # float
z = float(input('Zadejte délku třetí strany: ')) # float

# tři možné přepony (hypotenuse): x nebo y nebo z
from math import isclose

hypX = isclose(x**2, y**2 + z**2) # bool
hypY = isclose(y**2, z**2 + x**2) # bool
hypZ = isclose(z**2, x**2 + y**2) # bool

# Je nebo není pravúhlý?
isOrNot = 'je' if (hypX or hypY or hypZ) else 'není' # str

print(f'Zadaný trojúhelník {isOrNot} pravoúhlý.')
```

---

#### Rozšiřte příklad s Frodem a Gandalfem na tři členy Společenství prstenu. Podmíněnými výrazy vyberte nejstaršího ze tří možných.

Výchozí data v proměnných:

```python
Fr = 'Frodo'
FrAge = 50

Gd = 'Gandalf'
GdAge = 2000

Ar = 'Aragorn'
ArAge = 87

```

Řešení 1, pseudocode: (přibližný kód, pro lidi):

```
Jestli FrAge < GdAge pak:
  Frodo není nejstarší, tedy je to Gandalf nebo Aragorn
  a jestli ArAge < GdAge, je to Gandalf, jinak Aragorn
Jinak:
  není to Gandalf, ale Frodo nebo Aragorn
  a jestli FrAge < ArAge, je to Aragorn, jinak Frodo
```

```python
# Výsledný kód: tři ternární operace, tři porovnání:
oldest = (Gd if ArAge < GdAge else Ar) if FrAge < GdAge else (Ar if FrAge < ArAge else Fr)
# První závorky jsou nezbytné! Takto by to bylo bez zbytných závorek:
# oldest = (Gd if ArAge < GdAge else Ar) if FrAge < GdAge else Ar if FrAge < ArAge else Fr
```

Řešení 2, pseudocode:

```
Jestli FrAge < GdAge a zároveň ArAge < GdAge pak je to Gandalf.
Jinak zbývají Frodo a Aragorn a jestli FrAge < ArAge, je to Aragorn, jinak Frodo
```

```python
# Výsledný kód: dvě ternární operace, tři porovnání a jedna logická operace:
oldest = Gd if (FrAge < GdAge and ArAge < GdAge) else (Ar if FrAge < ArAge else Fr)
# Žádné závorky nejsou nezbytné! Takto je by to bylo zkrácené:
# oldest = Gd if FrAge < GdAge and ArAge < GdAge else Ar if FrAge < ArAge else Fr
```

Vytiskni výsledek:

```python
print(f'{Fr} is {FrAge}, {Gd} is {GdAge}, and {Ar} is {ArAge}.')
print(f'{oldest} is the oldest and therefore the wisest.')
```

---

#### Automat na vodu a vodku se zeptá zákazníka na jméno a pozdraví jej jménem. Nejdříve se zeptá se na věk: mladým pogratuluje k jejich mládí a starším k jejich moudrosti. Dále se zeptá, zda si zákazník žádá vodu nebo vodku. Starším prodá vodu i vodku, mladým ale jen vodu.

```python
jméno = input('Jak se jmenujete? ')
print(f'Dobrý den, pane/paní {jméno},')

věk = int(input('Kolik je Vám let? ')) # int

AGE = 18            # hranice dospělosti
mladistvý = věk<AGE # bool
print(f'Gratuluji k {"Vašemu mládí" if mladistvý else "Vaší moudrosti"}!')

volba = input('Přejete si vodu nebo vodku? ')
chciVodu = 'vodu' == volba # bool, True: vodu, False: vodku

# texty
dámVodu    = 'Zde je voda.'
dámVodku   = 'Zde je vodka.'
nedámVodku = 'Zde je voda místo vodky.'

# hotovo, rozhodnuto
výdej = (dámVodu if chciVodu else nedámVodku) if mladistvý else (dámVodu if chciVodu else dámVodku)
print('Děkuji za důvěru.', výdej)
```
