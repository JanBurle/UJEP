# 01 – Úvod, čísla

## Python

Shlédněte úvodní motivační video [Python za 100 sekund](https://www.youtube.com/watch?v=x7X9w_GIm1s).

- Programovací jazyk Python vytvořil cca. v r. 1990 [Guido van Rossum](https://en.wikipedia.org/wiki/Guido_van_Rossum).[^1]
- Jméno _Python_ je zvoleno podle [Monty Python's Flying Circus](https://en.wikipedia.org/wiki/Monty_Python%27s_Flying_Circus).
- Python patří mezi nejpopulárnější programovací jazyky, je velmi užitečné se jej naučit. (Spolu s C a JavaScriptem.)
- Cílem konstrukce Pythonu je možnost psát čitelný, elegantní, přehledný, přímočarý a jednoznačný kód.
- Python je vhodný jak pro začátečníky, tak pro experty. Je také častou volbou pro vědecké výpočty.
- _Python používá odsazení pro zachycení struktury programu._
- Používáme Python verze 3 (3.12).

[^1]: [Rossum's Universal Robots](https://cs.wikipedia.org/wiki/R.U.R) ㋡

Hlavním cílem kurzu je učit se algoritmizaci, což je schopnost řešit problémy pomocí [algoritmů](https://cs.wikipedia.org/wiki/Algoritmus) vyjádřených pomocí _strojových příkazů_. Strojem se rozumí počítací stroj, krátce počítač, který _provádí_ (_vykonává_) strojové příkazy.

Strojové příkazy (program počítacího stroje) se zapisují v _programovacím jazyce_. Programy jsou kolekce (nebo sekvence) příkazů. Příkazy budeme zapisovat v Pythonu.

## Prostředí

Programy se nejčastěji vytvářejí ve _vývojovém prostředí_. My budeme zpočátku používat [Jupyter](https://cs.wikipedia.org/wiki/Jupyter) Notebook v provedení [Google Colab](https://colab.research.google.com/).

- přihlašte se do svého Google účtu
- založte/otevřete si dokument (notebook, zápisník `.ipynb`) typu _Google Collaboratory_

V zápisníku lze vytvářet textové buňky pro poznámky, a kódové buňky pro kód. Kód lze přímo v zápisníku provést.

Pokud jste již pokročilí, samozřejmě můžete použít jiná prostředí (VSCode + instalovaný Python, PyCharm, ...).

## Literatura

Během cvičení budeme mj. odkazovat na oficiální dokumentaci [python.org/doc/](https://www.python.org/doc/).

## Vstup a výstup

Na počátku vstup a výstup textových dat do a z počítače probíhal [přepínači a světélky](https://www.cs.kent.edu/~rothstei/10051/HistoryPt4.htm), pomocí děrných štítků a tiskárny, dálnopisem, nebo na [prvních obrazovkách a klávesnicích](https://www.avplanners.com/blog/history-with-a-local-av-company-computer-monitors). Tento tzv. _řádkový_ vstup a výstup probíhá v Pythonu především pomocí _funkcí_ (_příkazů_) `input` a `print`.

Nejjednoduší výstup proběhne přímo po _vyhodnocení výrazu_ v kódové buňce (text za znakem `#` je _komentář_):

```python
1 # číslo jedna
```

```python
'haló' # text v uvozovkách
```

```python
"haló" # text v dvojitých uvozovkách
```

```python
haló # chyba (výjimka)
```

Chyba v posledním výrazu způsobil (_raised_) výjimku (_exception_), která ukončila běh programu (ano, už nejjednodušší výraz je program) a vypsala _obsah zásobníku_ (stack dump, traceback).

_Gemini dokáže vysvětlit, co se stalo. Umí i napovídat. Nespoléhejte na něj ale ve všem._

## Proměnné

Problém byl v tom, že slovo `haló` je neznámé, nedefinované. Můžeme ho ale použít jako _proměnnou_. Proměnná je pojmenovaná buňka v paměti, která obsahuje odkaz (referenci) na hodnotu, tzv _objekt_. (V Pythonu je vše nějaký objekt a objekt je instance _třídy_, také zvané _typ_.)

Odkaz se do proměnné přiřadí _operátorem_ `=`. Jména proměnných v Pythonu mohou obsahovat diakritiku (a více: [utf8](https://en.wikipedia.org/wiki/UTF-8)).

```python
tři = 1 + 2 # první řádek (příkaz, výraz) programu
tři         # poslední řádek, vypíše hodnotu
```

## Čísla

```python
type(tři)
```

```python
type(3)
```

```python
type(3.0)
```

Python rozeznává dva typy (**_třídy_**) čísel: `int` a `float`. `float` čísla se rozpoznají tím, že mají v zápisu desetinnou tečku.

S čísly lze provádět aritmetické operace:

| Operátor | Operace                    |
| -------: | :------------------------- |
|    x + y | sčítání                    |
|    x - y | odčítání                   |
|      - x | negace                     |
|   x \* y | násobení                   |
|    x / y | dělení                     |
|    x % y | zbytek po dělení (modulus) |
|   x // y | celočíselné dělení (floor) |
| x \*\* y | umocňování                 |

### Úkol:

Vykoušejte si aritmetické operace s čísly a experimentálně zjistěte, jak operace změní typ čísel. Operace lze kombinovat. Kombinované výrazy se vyhodnocují s ohledem na precedenci operátorů a závorky.

```python
1 + 2 * 3
```

```python
(1 + 2) * 3
```

```python
type((1 + 2) * 3)
```

```python
x = (1 + 2) * 3
type(x)
```

```python
type(2)
type(2.0)
type(2 / 3)
type(2.0 / 3)
type(2 // 3)
type(2.0 // 3)
# ...
```

### Otázky:

- Jaký je rozsah celých čísel v Pythonu? Je nějak omezený?
- Jak se chová dělení, celočíselné dělení, a zbytek po dělení, pokud se použijí záporná čísla?
- Co se stane při dělení nulou?

## Moduly (knihovny)

Python má řadu _rozšiřujících_ modulů. Jeden ze základních je modul `math`, který obsahuje řadu aritmetických _funkcí_.

```python
math.sin(1) # sin je metoda objektu math
```

(chyba)

```python
import math # modul je nutno importovat
math.sin(1)
```

### Otázky:

- Jaká je třída (typ) modulu `math`?
- Jaké funkce (metody) obsahuje modul `math`? (Nápověda: _dir(\<module name\>)_, _help(\<module name\>)_)

### modul `sys`

```python
import sys
sys.version # type(sys.version)
```

## _Úloha na doma:

- Seznamte se s možnostmi zápisníku Google Colab.
- Seznamte se s funkcemi/metodami modulu `math` a vyzkoušejte si výpočty (operace) s jejich použitím.

* Přečtěte si [dokumentaci modulu math](https://docs.python.org/3/library/math.html)

## Příště:

- [vstup a výstup, formátování řetězců](https://docs.python.org/3/tutorial/inputoutput.html)
- [input](https://docs.python.org/3/library/functions.html#input)
- [print](https://docs.python.org/3/library/functions.html#print)
- podmínečné výrazy (`if` - `else`)
