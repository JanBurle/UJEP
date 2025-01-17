# 04 – Podmínky, cykly, indexace, řetězce ...

## Logické výrazy

Jsou operace s hodnotami typu `bool`: `False` a `True`.

Logicke operace jsou: logický součin (konjunkce) `and`, logický součet (disjunkce) `or` a logická negace `not`. Precedence (přednost) těchto operátorů je `not`,`and`,`or`.

Tyto operace lze popsat _pravdivostními tabulkami_ ( F=`False`, T=`True`):

| a   | b   | a and b |
| :-- | :-- | ------: |
| F   | F   |       F |
| F   | T   |       F |
| T   | F   |       F |
| T   | T   |       T |

| a   | b   | a or b |
| :-- | :-- | -----: |
| F   | F   |      F |
| F   | T   |      T |
| T   | F   |      T |
| T   | T   |      T |

| a   | not a |
| :-- | ----: |
| F   |     T |
| T   |     F |

### 📱 Úloha:

_Sestavte program, který vypočítá a vypíše pravdivostní tabulky uvedených operací._

Další logické operace jsou např. [implikace](https://cs.wikipedia.org/wiki/Implikace) (jestliže _a_, pak _b_) a [exkluzivní disjunkce](https://cs.wikipedia.org/wiki/Exkluzivn%C3%AD_disjunkce) (exclusive or, _xor_), definované těmito tabulkami:

| a   | b   | implikace |
| :-- | :-- | --------: |
| F   | F   |         T |
| F   | T   |         T |
| T   | F   |         F |
| T   | T   |         T |

| a   | b   | xor |
| :-- | :-- | --: |
| F   | F   |   F |
| F   | T   |   T |
| T   | F   |   T |
| T   | T   |   F |

### 📱 Úloha:

_Vyjádřete operace **implikace** a **xor** pomocí operátorů **and**, **or**, **not**._

Poznámka: Ve skutečnosti by nám stačil jen jediný logický operátor: _nand_ (not and). Všechny ostatní operace je možné zkonstruovat pomocí tohoto operátoru.

| a   | b   | nand |
| :-- | :-- | ---: |
| F   | F   |    T |
| F   | T   |    T |
| T   | F   |    T |
| T   | T   |    F |

## De Morganovy zákony

[De Morganovy zákony](https://cs.wikipedia.org/wiki/De_Morganovy_z%C3%A1kony) jsou pravidla, která tvrdí:

1. Negace výsledku logického součinu proměnných = logický součet znegovaných proměnných
1. Negace logického součtu logických hodnot = logický součin negovaných hodnot

To jest:

```
not (a and b) == not a or  not b
not (a or  b) == not a and not b
```

### 📱 Úloha:

_Prověřte pomocí kódu, že pravidla opravdu platí._

## Palindromy

Na přednášce byl sestaven program, který ověřoval, zda zadaný řetězec (věta) je palindrom. Při testu českých palindromů se ignoruje:

- velikost písmen
- čárky a kroužek nad: á, é, í, ó, ú, ů, ý
- mezery
- číslice a speciální znaky

### 📱 Úloha:

_Napište takovýto program na rozpoznání palindromu._

## Indexace

Indexy (pozice elementů v kolekcích, např. písmena v řetězci) se ve většině programovacích jazyků počítají od nuly. Proč? Protože tzv. [modulární aritmetika](https://cs.wikipedia.org/wiki/Modul%C3%A1rn%C3%AD_aritmetika) leccos zjednodušuje!

```python
s = 'abcd'
s[0] # 'a'
```

S tím souvisí i skutečnost, že `range(i,j)` představuje interval hodnot zleva uzavřený ("včetně i") a zprava otevřený ("vyjma j"). Takové intervaly lze, mimo jiné, mnohem jednoduššeji skládat:

```python
# range() vrací objekt, nutno převést na seznam
print(list(range(8)))
print(list(range(8,16)))
print(list(range(16,23)))
print(list(range(0,8)) + list(range(8,16)) + list(range(16,23)))
```
