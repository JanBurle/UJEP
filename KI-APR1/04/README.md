# 01 – Podmínky, cykly, indexace, řetězce ...

**Úkol HW1.5: Logické spojky**

_Logické výrazy se vyhodnocují stejně jako relace na Boolovské hodnoty True nebo False. Tyto logické operace jsou v Pythonu AND (logický součin), OR (logický součet), NOT (logická negace). Logický součin se vyhodnotí jako pravda, pokud jsou oba výrazy pravdivé. Logický součet se vyhodnotí jako pravdivý, pokud je alespoň jeden výraz pravdivý. Logický negace obrací logickou hodnotu výrazu. Z True udělá False a obráceně. Tyto logické výrazy můžete kombinovat s pořadím předností NOT, AND, OR. Také jejich kombinací můžete vytvářet jiné Boolovské funkce (různoznačnost XOR, totožnost XNOR, implikaci, inhibici, aj.). Výrazy můžete i různě závorkovat. Vyzkoušejte si do proměnných `xlog1, xlog2, xlog3, xlog4` uložit pravdivostní hodnoty True nebo False a provést vámi vybrané logické operace. Minimálně si vyzkoušet předepsané._

Př.:

```
xlog1 = True
xlog2 = False
xlog3 = True
xlog4 = True

# logický součin dvou hodnot
log_soucin = xlog1 and xlog2
print(f"{xlog1} and {xlog2} = {log_soucin}")

# logický součin ctyr promennych
log_soucin = xlog1 and xlog2 and xlog3 and xlog4
print(f"{xlog1} and {xlog2} and {xlog3} and {xlog4} = {log_soucin}")

# negovaný logický součet NOR dvou proměnných
# ... doplnte

# různoznačnost XOR dvou proměnných
# ... doplnte

# implikace - budete si muset odvodit :)
# Nápověda pravdivostní tabulkou:
# xlog1  xlog2  vysledek
#   F      F       T
#   F      T       T
#   T      F       F
#   T      T       T
# ... doplnte
```

**Úkol HW1.6: DeMorganovy zákony**

_De Morganovy zákony jsou pravidla, která říkají_

1. Negace výsledku logického součtu proměnných = logickému součinu znegovaných proměnných
2. Negace výsledku logického součinu proměnných = logickému součtu znegovaných proměnných
   _Prověřte pomocí kódu v jazyce Python, že opravdu platí a strany si jsou rovny._

for : putpixel obrázky

https://cs.wikipedia.org/wiki/Modul%C3%A1rn%C3%AD_aritmetika
indexace retezce od nuly
od 0
index za konec IndexError
výrezy vlevo vvcetne, vpravo vyjma: proc: odectu konec od zacatku je delka
skladani intervalu

operace s retezci: replace, lower, [::-1]

program na palindromy

ChatGPT

funkce, dokumentacni retezec, typove anotace u parametru funkci a vysledkui

asymemtrie: retezec se prelozi pomoci tabulky
tabulka prelozi retezec
