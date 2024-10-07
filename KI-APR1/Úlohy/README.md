# Různé programovací úlohy

Zde budou přibývat různé úlohy, které nás napadnou.

## `float` (pro pokročilé)

Typ `float` (aproximace reálných čísel) má velký rozsah, ale je nepřesný. To je dáno tím, že jeho hardwarová implementace ve formátu [IEEE 754](https://en.wikipedia.org/wiki/Double-precision_floating-point_format)). Doména čísel `float` není spojitá, ale diskrétní, a hardware tedy realizuje pouze vybrané body na číselné ose.

## Úloha:

### a)

Napište program, který po zadání dvou vstupních hodnot:

1. počáteční desetinné číslo `fl0`
1. počet kroků `n`
   vypíše posloupnost `n`-ti čísel tak, jak jsou realizovatelná v typu `float`

### b)

Napište program, který po zadání vstupní hodnoty – desetinného čísla `fl` – vypíše nejbližší číslo typu `float`, které je k dispozici.
