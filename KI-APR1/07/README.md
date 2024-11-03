# 07 –

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

rekurze....

---

kolekce: objekty slouzici k ukladani jinych objektu: 0 a vice (mnoho)

- fixni nebo promenna velikost (dynamicka)
- modifikovatelna nbo ne
- homogenni nebo nehom.
- sekvencni (polozky maji urcenou pozici - index) nebo ostatni

seznam/list

- modif., dyn., predevsim homogenni, sekvencni

vyrez: podseznam / na rozdil od retezcu

s[1:2] = [1,2,3,4] nafoukbe se
s[1:2] = []
s.append()

casova slozitost
limitni (na zacatku se to chova jinak, az pozdeji je to napr. linearni)
vyznam pro velka n

O(1) = k
O(n) = k\*n
O(n\*\*2) = parabola, polynom
O(a\*\*n) expon.
O(log(n))

append() -> O(1)
insert() -> O(n)
len() -> O(1)
[i] -> O(1)
x in [...] -> O(n)

[] + []
del s[]
==
[] \* n

.clear()
.copy()

s1 = []
s2 = s1

s.copy(), s[:], list(s)

kdy delat kopii - kdyz jsou operace vzdalene a je to promenne
