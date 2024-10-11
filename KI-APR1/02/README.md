# 02 – Čísla `float` + modul `math`, výstup a vstup, formátované řetězce

## Čísla `float`

Čísla třídy (typu) `float` jsou nepřesná (respektive jsou přesná, ale jen pro diskrétní hodnoty, realizovatelné v hardware), a proto je nelze používat pro přesné výpočty a přesná porovnávání!

```python
5/7 == (2/7) * (5/2)
```

> False

```python
5/7
```

> 0.7142857142857143

```python
(2/7) * (5/2)
```

> 0.7142857142857142

```python
5/7 - (2/7) * (5/2)
```

> 1.1102230246251565e-16 # velmi malé číslo (numerická chyba)

Poslední číslo bylo vypsáno v tzv. _vědecké notaci (zápisu, scientific notation)_, ve formátu _mantissa_ a _exponent_.

Výhodou čísel `float` je jejich velký rozsah, nevýhodou jejich omezená přesnost.

`float` čísla lze porovnat např. takto (`abs` je nutné!!):

```python
abs((5/7) - ((2/7) * (5/2))) < 1e-10
```

Tj. jsou si čísla blízká? Nebo takto:

```python
import math
math.isclose(5/7, 2/7 * 5/2)
```

#### ❖ _Úloha: Modul [math](https://docs.python.org/3/library/math.html) obsahuje řadu funkcí pro práci s čísly `float`. Projděte si je._

## Řádkový výstup

V prvním cvičení jsme používali Python jako „kalkulačku“ – hodnota výrazu na poslední řádce byla vypsána na výstup. Pro řízený výstup je k dispozici _vestavěná_ funkce [print()](https://www.w3schools.com/python/ref_func_print.asp).

Různé typy:

```python
print(3)
```

```python
print(3.2)
```

```python
print(3/2)
```

```python
print('3/2')
```

Několik hodnot najednou (_pozicionální_ argumenty):

```python
print(3, 3.2, 3/2, '3/2')
```

Specifikace oddělovače (_pojmenovaný_ argument):

```python
print(3, 3.2, 3/2, '3/2', sep=' : ')
```

`print` přidává na konec (neviditelný) znak pro konec řádku (_newline_, _NL_) ...

```python
print('čísla: ')
print(3, 3.2, 3/2, '3/2')
```

... pokud neřekneme jinak:

```python
print('čísla: ', end='')
print(3, 3.2, 3/2,'3/2')
```

Explicitní konec řádku (escape sequence `\n`)

```python
print('čísla: ', end='//\n')
print(3, 3.2, 3/2, '3/2')
```

## Řádkový vstup

Vestavěná funkce [input()](https://www.w3schools.com/python/ref_func_input.asp).

```python
print('Enter your name:')
name = input()
print('Hello,', name)
```

S výzvou (prompt):

```python
name = input('Enter your name:')
print('Hello,', name, end='!\n')
```

`input()` vrací objekt typu `str` (string, řetězec):

```python
type(input('Enter your name:'))
```

Vestavěná funkce [int()](https://www.w3schools.com/python/ref_func_int.asp) se pokusí převést řetězec (nebo cokoli jiného) na číslo (objekt) typu `int`:

```python
int(3.2)
```

```python
int('3')
```

Ale ne:

```python
int('3.0')
```

Vestavěná funkce [float()](https://www.w3schools.com/python/ref_func_float.asp) se podobně pokusí převést daný objekt na objekt typu `float`:

Tohle už jde:

```python
float('3.0')
```

A tohle také:

```python
int(float('3.0')) # does int() truncate or round the float?
```

Nebo také (pokud má vstup správný formát):

```python
int(input('Enter an int:'))
```

#### ❖ Úloha

Kromě [vestavěných operátorů](https://www.w3schools.com/python/python_operators.asp) obsahuje Python také obsahuje celou řadu [vestavěných funkcí](https://www.w3schools.com/python/python_ref_functions.asp).

Projděte si tyto vestavěné funkce: `abs`, `dir`, `float`, `help`, `input`, `int`, `max`, `min`, `pow`, `print`, `range`, `str`, `type`.

## Formátování řetězců

Řetězce lze spojovat [operátorem +](https://www.w3schools.com/python/python_strings_concatenate.asp):

```python
name = input('Enter your name:')
print('Hello, ' + name + '!')
```

Od verze 3.6 lze použít tzv. [f-string](https://www.w3schools.com/python/python_string_formatting.asp) (řetězcovou interpolaci, string interpolation):

```python
name = input('Enter your name:')
print(f'Hello, {name}!')
```

#### ❖ Úloha

Napište program, který se uživatele zeptá na jméno, věk, bydliště (atd.) a pak vypíše text: _Dobrý den, ..., Vaším domovem je ... a za rok Vám bude ... let._

## Porovnávání a podmíněný výraz (ternární operátor)

Hodnoty lze porovnávat:

```python
a = 3
b = 4

# čísla
print('a == 3:', a==3)
print('a != 3:', a!=3)
print('a < 3:',  a<3)
print('a <= 3:', a<=3)
print('a > 3:',  a>3)
print('a >= 3:', a>=3)
print('a < b:',  a<b)

# řetězce
print("'a'=='b'", 'a'=='b')
print("'a'<='b'", 'a'<='b')
```

Podle výsledku porovnání (pravdivostní/booleovská hodnota) lze vybrat jednu ze dvou hodnot:

```python
3 if True else 4
```

```python
3 if False else 4
```

```python
a = 3
b = 4
menší = a if a<b else b
print('menší je', menší)
```

```python
Fr = 'Frodo'
FrAge = 50

Gd = 'Gandalf'
GdAge = 2000

print(f'{Fr} is {FrAge} and {Gd} is {GdAge}.')
print(f'{Gd if FrAge<GdAge else Fr} is older and therefore wiser.')
```

## Booleovská (boolean) algebra

Práce s logickými výrazy (`and`, `or`, `not`) a hodnotami (`False`, `True`). Typ: `bool`.

```python
print(type(False), type(True), 3<4, type(3<4)) # atd.
print(3<4 and 4<5)
print(3<4 and 3>4)
print(3<4 or 3>4)
print(not 3>4)
```

#### ❖ Úlohy

- Zadejte délku odvěsen pravoúhlého trojúhelníku a vypište délku přepony.
- Zadejte délku stran trojúhelníku a určete, zda je trojúhelník pravoúhlý.
- _Vymyslete si sami podobnou úlohu._

- Rozšiřte příklad s Frodem a Gandalfem na tři členy Společenství prstenu. Podmíněnými výrazy vyberte nejstršího ze _tří_ možných.

- Automat na vodu a vodku se zeptá zákazníka na jméno a pozdraví jej jménem. Nejdříve se zeptá se na věk: mladým pogratuluje k jejich mládí a starým k jejich moudrosti. Dále se zeptá, zda si zákazník žádá vodu nebo vodku. Starým prodá vodu i vodku, mladým ale jen vodu.
