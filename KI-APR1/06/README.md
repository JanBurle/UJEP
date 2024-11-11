# 06 – Želví grafika

Instalace:

```python
!pip3 install ColabTurtle
```

Import a dokumentace:

```python
from ColabTurtle import Turtle as T
help(T)
```

Pohyb a zatáčení:

```python
T.initializeTurtle()
T.forward(100)
T.right(90)
T.forward(100)
T.back(200)
T.left(90)
T.forward(100)
```

Tvar, domů, otáčení:

```python
T.initializeTurtle()
T.shape('circle')
for deg in range(0,360,60):
  T.home()
  T.setheading(deg)
  T.forward(60)
```

Šířka čáry:

```python
T.initializeTurtle()
T.shape('circle')
for i in range(6):
  T.width(i+1)
  T.pendown()
  T.forward(10)
  T.penup()
  T.forward(10)
```

Přerušovaná čára:

```python
T.initializeTurtle()
T.shape('circle')

centerX = T.window_width()  // 2
centerY = T.window_height() // 2
for i in range(6):
  T.penup()
  T.goto(centerX + i*10, centerY + i*5)
  T.pendown()
  T.forward((i+1) * 20)
```

Barvy:

```python
T.initializeTurtle()
T.shape('circle')

T.color('red')
T.forward(20)
T.color('green')
T.forward(20)
T.color(0,0,255) # blue
T.forward(20)
```

### 📱 Úlohy:

- Nakreslete čtverec.
- Nakreslete trojúhelník.
- Nakreslete šestiúhelník.
- Nakreslete pětiúhelník.
- Nakreslete n-úhelník.
- Nakreslete kruh.
- Nakreslete hvězdičku.
- Vyplňte plochu čtverci.
- Vyplňte plochu hvězdičkami.
- ...

Pro pokročilé – rekurze:

- Nakreslete strom.
