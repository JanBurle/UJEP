# Želví grafika

- Nakreslete trojúhelník, čtverec, pětiúhelník, šestiúhelník ... n-úhelník, kruh, hvězdičku.
- Vyplňte plochu čtverci, hvězdičkami.

Pro pokročilé – rekurze:

- Nakreslete strom.

### Příprava

```python
# instalace
!pip3 install ColabTurtle
```

```python
# import
from ColabTurtle import Turtle as T
```

```python
# show documentation
help(T)
```

### trojúhelník, čtverec, pětiúhelník, šestiúhelník

```python
for i in range(3):
  T.forward(100)
  T.right(120)
```

```python
for i in range(4):
  T.forward(100)
  T.right(90)
```

```python
for i in range(5):
  T.forward(100)
  T.right(72)
```

```python
for i in range(6):
  T.forward(100)
  T.right(60)
```

### n-úhelník

Insight:

```
* 3 * 120 = 360
* 4 *  90 = 360
* 5 *  72 = 360
* 6 *  60 = 360
* n *  a  = 360 // počet stran * úhel = 360
```

```python
def polygon(n: int, l:int):
  """ Draw a polygon of n sides, each side l long."""
  a = 360 / n # angle
  for i in range(n):
    T.forward(l)
    T.right(a)
```

### Test

```python
def skipTo(x:int, y:int):
  T.penup()
  T.goto(x,y)
  T.pendown()

T.initializeTurtle(8, (800,140))

skipTo(10,100)
polygon(3, 60)

skipTo(110,100)
polygon(4, 60)

skipTo(210,100)
polygon(5, 60)

skipTo(310,100)
polygon(6, 60)

skipTo(410,100)
polygon(7, 60)

skipTo(510,100)
polygon(60, 2)
```

### Hvězdičky

```python
def star(n: int, l: int):
  """Draw a star with n points and line length l. n must be odd."""
  if not (0 < n and n%2): # check n validity
    raise Exception('n must be positive and odd')

  a = 180 - 180/n
  for i in range(n):
    T.forward(l)
    T.right(a)

def star2(n: int, l: int):
  """Draw a star with n points, hollow middle, and line length l."""
  a = 30 # 360/n # point angle
  a1 = 180 - a
  a2 = a - 180 + 360/n
  for i in range(n):
    T.forward(l)
    T.right(a1)
    T.forward(l)
    T.right(a2)

# test
T.initializeTurtle(9)
T.shape('circle')
star2(11,60)
for i in range(1,2):
  skipTo(100 * i, 100)
  star(n, 80)
  skipTo(100 * i, 200)
  star2(n, 60)
```

### Vyplňte plochu barevnými čtverci

```python
T.initializeTurtle()
T.shape('circle')
T.speed(13)


from random import randint

def randColor() -> tuple[int,int,int]:
  """ Random colour. """
  r = randint(0,255)
  g = randint(0,255)
  b = randint(0,255)
  return (r,g,b)

def square(x:int, y:int, size:int):
  T.penup()
  T.goto(x,y)
  T.pendown()
  T.setheading(0)
  T.color(randColor())

  for i in range(4):
    T.forward(size)
    T.right(90)

space = 12
size  = 36
sps   = space + size
for x in range(space, T.window_width() - sps, sps):
  for y in range(space, T.window_height() - sps, sps):
    square(x,y,size)
```

### Nakreslete rekurzivní strom

```python
T.initializeTurtle()
T.speed(8)
T.shape('circle')
T.penup()
T.backward(220)

def tree(len, angle):
  # když je podstrom malý, nekreslit a ukončit tak rekurzi
  if len < 20: return

  # kmen
  T.forward(len)
  # levý podstrom
  T.left(angle)
  tree(len*2//3, angle)
  # pravý podstrom
  T.right(angle*2)
  tree(len*2//3, angle)
  # vycouvat zpět na začátek
  T.left(angle)
  T.backward(len)

# test
T.pendown()
tree(180, 44)
```

### Nakreslete barevný rekurzivní les

```python
from random import randint
brown      = (150,75,0)   # hnědý kmen
darkgreen  = (89,179,0)   # tmavě zelené větve
lightgreen = (155,255,51) # světle zelené listí

# přechod mezi barvou kmenu a větví podle hloubky
def mixColor(depth: int) -> tuple[int,int,int]:
  maxDepth = 6 # omození hloubky pro výpočet
  depth = min(depth, maxDepth)
  c2 = depth   # koeficienty barev
  c1 = 4-c2

  # přechod mezi barvami
  r1,g1,b1 = brown
  r2,g2,b2 = darkgreen
  r = int((r1*c1 + r2*c2) / D)
  g = int((g1*c1 + g2*c2) / D)
  b = int((b1*c1 + b2*c2) / D)

  return (r,g,b)

def tree(size, depth=0):
  # konec větví - list
  if size<6:
    T.width(randint(2,4))
    T.color(lightgreen)
    size = randint(3,6)
    T.forward(size)
    T.back(size)
    return

  # úhel vlevo a vpravo
  al = 31 + randint(-8, 8)
  ar = 29 + randint(-8, 8)
  # velikost podstromu vlevo a vpravo
  sl = .7 + randint(-10, 10) / 100
  sr = .65 + randint(-10, 10) / 100

  # kmen
  T.color(mixColor(depth))
  T.width(int(size)//20 + 1)
  T.forward(size)
  # levý podstrom
  T.left(al)
  tree(size*sl, depth+1)
  # pravý podstrom
  T.right(al + ar)
  tree(size*sr, depth+1)

  # vycouvat zpět
  T.left(ar)
  T.penup()
  T.back(size)
  T.pendown()

# lesík
T.initializeTurtle()
T.shape('circle')
T.speed(13)

for i in range(4):
  T.penup()
  T.goto(120 + 140 * i, 460)
  T.pendown()
  tree(40 + 16 * i)

T.hideturtle()
```

```python
# sad s jabloněmi, zatím bez jablíček
T.initializeTurtle()
T.hideturtle()
T.speed(13)

for j in range(4):
  for i in range(4):
    T.penup()
    T.goto(randint(-12,12) + 120 + 140*i + 30*j,
           randint(-12,12) + 460 - 80*j)
    T.pendown()
    tree(33)
```
