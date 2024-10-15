# Zadejte délku odvěsen pravoúhlého trojúhelníku a vypište délku přepony.

a = float(input('Zadejte délku první odvèsny: ')) # float
b = float(input('Zadejte délku druhé odvèsny: ')) # float

import math
c = math.sqrt(a*a + b*b) # float

print(f'Délka přepony pravúhlého trojúhelníku je {c:.2f}.')
