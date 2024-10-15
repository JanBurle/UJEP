# Rozšiřte příklad s Frodem a Gandalfem na tři členy Společenství prstenu.
# Podmíněnými výrazy vyberte nejstaršího ze tří možných.

Fr = 'Frodo'
FrAge = 50

Gd = 'Gandalf'
GdAge = 2000

Ar = 'Aragorn'
ArAge = 87

# Řešení 1, pseudocode: (přibližný kód, pro lidi)
# jestli FrAge < GdAge pak
#     Frodo není nejstarší, tedy je to Gandalf nebo Aragorn
#     a jestli ArAge < GdAge, je to Gandalf, jinak Aragorn
# jinak
#     není to Gandalf, ale Frodo nebo Aragorn
#     a jestli FrAge < ArAge, je to Aragorn, jinak Frodo
#
# Výsledný kód: tři ternární operace, tři porovnání:
oldest = (Gd if ArAge < GdAge else Ar) if FrAge < GdAge else (Ar if FrAge < ArAge else Fr)
# První závorky jsou nezbytné! Takto by to bylo bez zbytných závorek:
# oldest = (Gd if ArAge < GdAge else Ar) if FrAge < GdAge else Ar if FrAge < ArAge else Fr

# Řešení 2, pseudocode:
# jestli FrAge < GdAge a zároveň ArAge < GdAge pak je to Gandalf
# jinak zbývají Frodo a Aragorn
#     a jestli FrAge < ArAge, je to Aragorn, jinak Frodo
#
# Výsledný kód: dvě ternární operace, tři porovnání a jedna logická operace:
# oldest = Gd if (FrAge < GdAge and ArAge < GdAge) else (Ar if FrAge < ArAge else Fr)
# Žádné závorky nejsou nezbytné! Takto je by to bylo zkrácené:
# oldest = Gd if FrAge < GdAge and ArAge < GdAge else Ar if FrAge < ArAge else Fr

print(f'{Fr} is {FrAge}, {Gd} is {GdAge}, and {Ar} is {ArAge}.')
print(f'{oldest} is the oldest and therefore the wisest.')

# Úloha: nakreslete si rozhodovací graf (strom).
