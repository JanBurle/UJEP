# 07 – Kolekce

Kolekce jsou objekty sloužící k ukládání jiných objektů (položek, prvků, elementů). Položek může být 0 nebo vice, potenciálně dokonce velmi mnoho.

Kolekce mohou:

- být modifikovatelné (mutable) nebo neměnné (immutable)
- mít fixní nebo proměnnou (dynamickou) velikost
- být homogenní (stejnorodé) nebo nehomogenní.
- být sekvenční (jejich položky mají určitou pozici/index) nebo jiné

### seznam / list

Seznam je modifikovatelná, dynamická, nehomogenni (ale často používaná jako homogenní), sekvenční kolekce.

Seznam lze zapsat (vytvořit) jako literál:

```python
# prázdný seznam
[]

# seznam čísel
[0,1,2,3]

# seznam z podseznamy
['a', ['A', 8, False], 4+5]
```

Nebo z iterovatelného objektu vestavěnou funkcí `list()`:

```python
list([1,2,3])   # seznam ze seznamu (prázdná operace)
list(range(4))  # seznam z range()
list('abc')     # seznam písmen v řetězci
list((2,4,'b')) # seznam z entice
list({5,'b',7}) # seznam z entice (položky mají nedefinované pořadí)
```

### n-tice / tuple

N-tice je nemodifikovatelná, statická, nehomogenni, sekvenční kolekce.

N-tice se vytváří jako literál:

```python
()          # prázdná
('a',)      # jednice
('a','b')   # dvojice
('a','b',8) # trojice
```

Nebo vestavěnou funkcí:

```python
tuple()    # prázdná
tuple([])
tuple([10])
tuple([10,20])
tuple({})
tuple({'b',4,'y','a',5,1}) # nedefinované pořadí
tuple('abcd')
```

<!-- Další kolekcí je ntice, která je nemutabilní kolekce, tedy prvky uvnitř kolekce nelze měnit, l

1. index(obj) = vrátí index, na kterém se objekt nachází
2. count(obj) = vrátí počet nálezů zadaného objektu v ntici

Tato kolekce je velice minimalistická ve svém chování. Její využití je spíše významové.

| **add**(self, value, /)
| Return self+value.
|
| **contains**(self, key, /)
| Return key in self.
|
| **eq**(self, value, /)
| Return self==value.
|
| **ge**(self, value, /)
| Return self>=value.
|
| **getattribute**(self, name, /)
| Return getattr(self, name).
|
| **getitem**(self, key, /)
| Return self[key].
|
| **getnewargs**(self, /)
|
| **gt**(self, value, /)
| Return self>value.
|
| **hash**(self, /)
| Return hash(self).
|
| **iter**(self, /)
| Implement iter(self).
|
| **le**(self, value, /)
| Return self<=value.
|
| **len**(self, /)
| Return len(self).
|
| **lt**(self, value, /)
| Return self<value.
|
| **mul**(self, value, /)
| Return self*value.
|
| **ne**(self, value, /)
| Return self!=value.
|
| **repr**(self, /)
| Return repr(self).
|
| **rmul**(self, value, /)
| Return value*self.
|
| count(self, value, /)
| Return number of occurrences of value.
|
| index(self, value, start=0, stop=9223372036854775807, /)
| Return first index of value. -->

### nnožina / set

Množina je modifikovatelná, statická, nehomogenni, sekvenční kolekce.

Množina se vytváří jako literál:

```python
{}              # prázdná
{3,2,2,1}       # bez duplikátů
{3,'b', 2,'a'}  # nedefinované pořadí
```

Nebo vestavěnou funkcí:

```python
set()
set([2,4,6])
set(range(6))
set((2,4,1))
set('abcd')
```

<!-- Poslední kolekcí je množina, která je mutabilní kolekce. Její využití souvisí s její vlastnost

1. union(set) = sjednocení volající množiny (ta která metodu volá pomocí tečky) a argumentové
2. intersection(set) = průnik volající množiny s argumentovou množinou
3. difference(set) = smaže prvky z volající množiny, které jsou v argumentové množině
4. symetric_difference(set) = sjednocení prvků množin, od kterého se odečte průnik množin
5. issubset(set) = zjistí, zda je volaná množina podmnožinou argumentové
6. issuperset(set) = zjistí, zda je volaná množina nadmnouzinou argumentové
7. isdisjoint(set) = zjistí, zda množiny neobsahují stejné položky

Využití množiny jako kolekce tedy souvisí s aplikacemi, kde je zapotřebí využívat množinovou m -->

<!-- dict() -> new empty dictionary
| dict(mapping) -> new dictionary initialized from a mapping object's
| (key, value) pairs
| dict(iterable) -> new dictionary initialized as if via:
| d = {}
| for k, v in iterable:
| d[k] = v
| dict(**kwargs) -> new dictionary initialized with the name=value pairs
| in the keyword argument list. For example: dict(one=1, two=2)
|
| Built-in subclasses:
| StgDict
|
| Methods defined here:
|
| **contains**(self, key, /)
| True if the dictionary has the specified key, else False.
|
| **delitem**(self, key, /)
| Delete self[key].
|
| **eq**(self, value, /)
| Return self==value.
|
| **ge**(self, value, /)
| Return self>=value.
|
| **getattribute**(self, name, /)
| Return getattr(self, name).
|
| **getitem**(...)
| x.**getitem**(y) <==> x[y]
|
| **gt**(self, value, /)
| Return self>value.
|
| **init**(self, /, \*args, **kwargs)
| Initialize self. See help(type(self)) for accurate signature.
|
| **ior**(self, value, /)
| Return self|=value.
|
| **iter**(self, /)
| Implement iter(self).
|
| **le**(self, value, /)
| Return self<=value.
|
| **len**(self, /)
| Return len(self).
|
| **lt**(self, value, /)
| Return self<value.
|
| **ne**(self, value, /)
| Return self!=value.
|
| **or**(self, value, /)
| Return self|value.
|
| **repr**(self, /)
| Return repr(self).
|
| **reversed**(self, /)
| Return a reverse iterator over the dict keys.
|
| **ror**(self, value, /)
| Return value|self.
|
| **setitem**(self, key, value, /)
| Set self[key] to value.
|
| **sizeof**(...)
| D.**sizeof**() -> size of D in memory, in bytes
|
| clear(...)
| D.clear() -> None. Remove all items from D.
|
| copy(...)
| D.copy() -> a shallow copy of D
|
| get(self, key, default=None, /)
| Return the value for key if key is in the dictionary, else default.
|
| items(...)
| D.items() -> a set-like object providing a view on D's items
|
| keys(...)
| D.keys() -> a set-like object providing a view on D's keys
|
| pop(...)
| D.pop(k[,d]) -> v, remove specified key and return the corresponding value.
|
| If the key is not found, return the default if given; otherwise,
| raise a KeyError.
|
| popitem(self, /)
| Remove and return a (key, value) pair as a 2-tuple.
|
| Pairs are returned in LIFO (last-in, first-out) order.
| Raises KeyError if the dict is empty.
|
| setdefault(self, key, default=None, /)
| Insert key with a value of default if key is not in the dictionary.
|
| Return the value for key if key is in the dictionary, else default.
|
| update(...)
| D.update([E, ]**F) -> None. Update D from dict/iterable E and F.
| If E is present and has a .keys() method, then does: for k in E: D[k] = E[k]
| If E is present and lacks a .keys() method, then does: for k, v in E: D[k] = v
| In either case, this is followed by: for k in F: D[k] = F[k]
|
| values(...)
| D.values() -> an object providing a view on D's values
|
| ----------------------------------------------------------------------
| Class methods defined here:
|
| **class_getitem**(...) from builtins.type
| See PEP 585
|
| fromkeys(iterable, value=None, /) from builtins.type
| Create a new dictionary with keys from iterable and values set to value.
|
| ----------------------------------------------------------------------
| Static methods defined here:
|
| **new**(\*args, **kwargs) from builtins.type
| Create and return a new object. See help(type) for accurate signature.
|
| ----------------------------------------------------------------------
| Data and other attributes defined here:
|
| **hash** = None -->

## Seznam

Seznam je nejpoužívanější ze zmíněných kolekcí. Operaci nad seznamy:

```python
lst  = [1,2,3]  # seznam
lst1 = lst      # odkazuje na stejný seznam jako lst
lst2 = [1,2,3]  # jiný seznam

# seznamy lze porovnávat
lst == lst2
lst != lst2
lst <  lst2
lst <= lst2
lst >  lst2
lst >= lst2

# seznamy lze:
3 in lst      # testovat na přítomnost prvku
lst[2]        # indexovat
lst[-1]
lst + [4]     # konkatenovat
lst.copy()    # kopírovat
lst * 3       # replikovat (množit)
4 * lst
lst[0::2]     # řezat
len(lst)      # měřit (zjistit délku)
print(lst)    # tisknout

# obracet
reversed(lst) # iterátor v opačném směru
lst.reverse() # obráccení na místě (in-place, in-situ)

# přidávání a ubírání prvků na konci seznamu
lst.append(8) # přidat na konec
lst.pop()     # ubrat z konce (zásobník)

# přidávání a ubírání prvků jinde než na konci seznamu
lst.insert(0, 88) # vložení prvku na zadaný index
del lst[0]    # smazání prvku

# přidání seznamu z iterovatelného objektu na konec seznamu
lst.extend(range(3))

# odebrání prvku, pokud je nalezen
lst.remove(3)
# počet nalezených prvků
lst.count(2)

# setřídění prvků - seznam musí být homogenní
lst.sort()

# vyprázdnění seznamu
lst.clear()
```

Výřez seznamu je (pod)seznam.

```python
s = list('abcd')
s[1:3]            # výřez
s[1:3] = [1,2,3]  # "nafouknutí"
s[4:] = []        # zkrácení
```

## Časová složitost (complexity)

["Big O"](https://en.wikipedia.org/wiki/Big_O_notation) - limitní chování funkce/algoritmu při rostoucím počtu prvků _n_.

(Limitní/asymptotní chování: významné pro velká _n_. Na začátku se chová jinak, až později je to např. lineární.)

```
O(1)      = k (konstanta), konstantní čas
O(n)      = k*n, lineární
O(a**2)   = parabola (polynom, použitelné pro omezená n)
O(a\*\*n) = exponenciální (nepoužitelné)
O(log(n)) = logaritmické, použitelné
```

`append()`: O(1)

```python
for n in [10,1000,10_000,100_000,1000_000]:
  lst = list(range(n))
  %time lst.append(11)
```

`insert()`: O(n)

```python
for n in [10,1000,10_000,100_000,1000_000]:
  lst = list(range(n))
  %time lst.insert(0,11)
```

### 📱 Úloha

Odhadněte/změřte časovou složitost dalších operací nad seznamem: délka (`len(lst)`), indexace, sort, ...

### 📱 Úloha

Rekurzivní definice faktoriálu má složitost O(n), a lze ji použít:

```python
def fact(n:int) -> int:
  return 1 if 0==n else n * fact(n-1)

for n in [0,10,20,30,40,50,60,70]:
  %time print(n, fact(n))
```

Podobnou definici Fibonacciho řady ale nelze pro n větší než asi 30 použít. Proč?

```python
def fib(n:int) -> int:
  return n if n in [0,1] else fib(n-1) + fib(n-2)

for n in range(20):
  print(n,fib(n))
# for n in range(40):
#   print(n,fib(n))
```

### 📱 Úlohy

#### Počet samohlásek

Vypočítejte seznam dvojic (jméno, počet samohlásek ve jméně). Jména jsou zadaná v připraveném seznamu.

```python
jména = ["Pavel", "Milan", "Alena", "Rostislavomir"]
#doplnte kod

#vysledek = [("Pavel", 2), ("Milan", 2), ("Alena", 3), ("Rostislavomir", 5)]
```

#### Přihlašovací systém

Napište program, který požádá uživatele o login a heslo.

Program následně zkontroluje, zda se zadaná dvojice (login, heslo) nachází v seznamu registrovaných uživatelů. Pokud ano, program vypíše zprávu o úspěšném přihlášení.

Pokud ne, tak program zjistí, zda se v seznamu nachází alespoň login. Pokud ano, tak vypíše zprávu o nesprávném heslu.

Pokud se v seznamu login nenachází, tak program uživateli se zaregistrovat: přidá se zadaný login a heslo mezi registrované uživatele.

```python
users = [('Pavel', '1234'), ('Zbyněk', 'heslo')]
# ...
```

#### Šibenice

Naprogramujte konzolovou verzi hry šibenice. Zadaný je řetězec - tajenku (slovo nebo frázi), kterou hráč nevidí. Místo něj na počátku na obrazovce vidí pouze podtržítka. Hra hráče požádá o zvolené písmeno. Pokud toto písmeno bylo už hádáno, hra požádá o jiné písmeno. Pokud hráč písmeno ještě nehádal, tak program zjistí, zda se písmeno v tajence nachází. Pokud ne, tak hráčovi ubere život. Pokud ano, tak místo podtržítka zobrazí uhádnuté písmeno odkryto. Hra končí, když hráč uhádne tajenku, nebo když mu dojdou životy.

#### Hráči

Mějme seznam hráčů a jejich skóre v turnaji:

```
hráči = [("Pavel", 5), ("Honza", 3), ("Jana", 7), ("Milan", 4), ("Michaela", 9)]
```

1. Vypište jméno nejlepšího a nejhoršího hráče (podle skóre).

2. Vypište hráče v pořadí od nejlepšího po nejhoršího.

3. Vypište nejlepší 3 (top-3) hráče.

<!--
while loop
range(8)
print: range(0,8)
iterable - na pozadani vraci jednotlive objekty posloupnosti

r = iter(range(8))
iterator

next(r)...
StopIteration ... for to chyti
napsat si nahradu for pomoci while/try

iterovatelny objekt
vraci iterator je na jedno pouziti, jednosmerny ... vycerpan

iter(s)

for v in iterable

konecne i nekonecne iteratory

for c in s[::2]:

pyth. idiom
for i,c in enumerate(s)

next - duple

reversed(iterable)

reversed(range(len(s)))

1url.cz/@jf_workspace

rekurze.... -->
