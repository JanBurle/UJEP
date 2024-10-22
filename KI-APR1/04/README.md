# 01 – Podmínky, cykly, indexace, řetězce ...

## Logické výrazy

Jsou operace s hodnotami typu `bool`: `False` a `True`.

Logicke operace jsou: logický součin (konjunkce) `and`, logický součet (disjunkce) `or` a logická negace `not`. Precedence (přednost) těchto operátorů je `not`,`and`,`or`.

Tyto operace lze popsat _pravdivostními tabulkami_ ( F=`False`, T=`True`):

| a   | b   | a and b |
| :-- | :-- | :------ |
| F   | F   | F       |
| F   | T   | F       |
| T   | F   | F       |
| T   | T   | T       |

| a   | b   | a or b |
| :-- | :-- | :----- |
| F   | F   | F      |
| F   | T   | T      |
| T   | F   | T      |
| T   | T   | T      |

| a   | not a |
| :-- | :---- |
| F   | T     |
| T   | F     |

#### ❖ Úloha:

_Sestavte program, který vypočítá a vypíše pravdivostní tabulky uvedených operací._

Další logické operace jsou např. [implikace](https://cs.wikipedia.org/wiki/Implikace) (jestliže _a_, pak _b_) a [exkluzivní disjunkce](https://cs.wikipedia.org/wiki/Exkluzivn%C3%AD_disjunkce) (exclusive or, _xor_), definované těmito tabulkami:

| a   | b   | implikace |
| :-- | :-- | :-------- |
| F   | F   | T         |
| F   | T   | T         |
| T   | F   | F         |
| T   | T   | T         |

| a   | b   | xor |
| :-- | :-- | :-- |
| F   | F   | F   |
| F   | T   | T   |
| T   | F   | T   |
| T   | T   | F   |

#### ❖ Úloha:

_Vyjádřete implikaci a xor pomocí operátorů and, or, not._

Poznámka: Ve skutečnosti by nám stačil jen jediný logický operátor: _nand_ (not and). Všechny ostatní operace je možné zkonstruovat pomocí tohoto operátoru.

| a   | b   | nand |
| :-- | :-- | :--- |
| F   | F   | T    |
| F   | T   | T    |
| T   | F   | T    |
| T   | T   | F    |

## De Morganovy zákony

[De Morganovy zákony](https://cs.wikipedia.org/wiki/De_Morganovy_z%C3%A1kony) jsou pravidla, která tvrdí:

1. Negace výsledku logického součinu proměnných = logickému součtu znegovaných proměnných
1. Negace logického součinu logických hodnot = logický součet negovaných hodnot

#### ❖ Úloha:

_Prověřte pomocí kódu, že pravidla opravdu platí._

## Palindromy

Na přednášce byl sestaven program, který ověřoval, zda zadaný řetězec (věta) je palindrom. Při testu českých palindromů se ignoruje:

- velikost písmen
- čárky a kroužek nad: á, é, í, ó, ú, ů, ý
- mezery
- číslice a speciální znaky

#### ❖ Úloha:

_Napište takovýto program na rozpoznání palindromu._

## Indexace

Indexy (pozice elementů v kolekcích, např. písmena v řetězci) se ve většině programovacích jazyků počítají od nuly. Proč? Protože tzv. [modulární aritmetika](https://cs.wikipedia.org/wiki/Modul%C3%A1rn%C3%AD_aritmetika) leccos zjednodušuje!

S tím souvisí i skutečnost, že `range(i,j)` představuje interval hodnot zleva uzavřený ("včetně i") a zprava otevřený ("vyjma j"). Takové intervaly lze, mimo jiné, mnohem jednoduššeji skládat:

```python
# range() vrací objekt, nutno převést na seznam
print(list(range(8)))
print(list(range(8,16)))
print(list(range(16,23)))
print(list(range(0,8)) + list(range(8,16)) + list(range(16,23)))
```

## Cykly (smyčky)

Jak psát cykly víte. Pro procvičení cyklů budeme pracovat s obrázky, pomocí modulu [PIL](https://pythonexamples.org/python-pillow/).

Vytvoříme obrázek:

```python
from PIL import Image   # objekt pro práci s obrázky

width  = 120
height = 80
size = (width, height)  # závorky jsou důležité: n-tice (tuple)

img = Image.new('RGB', size) # nový obrázek
img                     # zobraz
```

Pracujeme s body (pixel = _picture element_) v obrázku:

```python
print(img.getpixel((10,10)))  # černá (0, 0, 0)
green = (0,255,0)
img.putpixel((10,10),green)
print(img.getpixel((10,10)))  # zelená
img
```

### ❖ Úloha:

_Pomocí cyklů namalujte do obrázku pruhy: vodorovné, svislé, křižující se, atd., různých barev._
