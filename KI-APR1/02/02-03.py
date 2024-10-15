# Zadejte délku stran trojúhelníku a určete, zda je trojúhelník pravoúhlý.

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
