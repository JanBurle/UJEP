Příprava:

```python
# imports
from PIL import Image
from requests import get as getUrl

# building stones (useful functions)
def newImage(size: tuple[int,int]) -> Image.Image: # <- type anotations
  """ Create a new RGB image. """
  return Image.new('RGB', size)

# image from url
def getImage(url: str) -> Image.Image:
  """ Fetch an image from url. """
  return Image.open(getUrl(url, stream=True).raw)

# named colours
red     = (255,0,0)
green   = (0,255,0)
blue    = (0,0,255)
cyan    = (0,255,255)
magenta = (255,0,255)
yellow  = (255,255,0)
white   = (255,255,255)
black   = (0,0,0)
```

Vytvořte prázdný obrázek a vyplňte jej zvolenou barvou:

```python
# brute force / to practice loops
def fill(img, color):
  for w in range(img.width):
    for h in range(img.height):
      pos = (w,h) # position
      img.putpixel(pos, color)

size = (120,48)
img = newImage(size)
display(img)

for color in (red, green, blue):
  fill(img, color)
  display(img)
```

Vytvořte prázdný obrázek namalujte do něj pruhy: vodorovné, svislé a křižující se:

```python
# switch red and blue colours
def redBlue(i: int):
  rb = (i//12)%2 # střídání barev po dvanácti px
  return red if rb else blue

# switch red colour and nothing
def onlyRed(i: int):
  rb = (i//12)%2 # střídání barvy/nebarvy po dvanácti px
  return red if rb else False

size = (120,60)
img = newImage(size)

# horizontal red/blue stripes
for x in range(img.width):
  for y in range(img.height):
    img.putpixel((x,y), redBlue(y))

display(img)
print()

# vertical red/blue stripes
for x in range(img.width):
  for y in range(img.height):
    img.putpixel((x,y), redBlue(x))

display(img)
print()

# crossed stripes
for x in range(img.width):
  for y in range(img.height):
    img.putpixel((x,y), redBlue(y))
    vertRed = onlyRed(x)
    if vertRed:
      img.putpixel((x,y), vertRed)

display(img)
```

Načtěte obrázek a aplikujte na něj filtr, který konvertuje barvy v obrázku na stupnici šedi, na černou a bílou, na tři "kanály" (složky) - červený, zelený a modrý:

```python
imgUrl = 'https://i.imgflip.com/2/7nx4qw.jpg'

img = getImage(imgUrl)
display(img)
print(img)

# gray scale
img = getImage(imgUrl)
for x in range(img.width):
  for y in range(img.height):
    r,g,b = img.getpixel((x,y))
    gray = (r+g+b) // 3
    img.putpixel((x,y), (gray,gray,gray))

display(img)

# black and white
img = getImage(imgUrl)
bwThreshold = 128
for x in range(img.width):
  for y in range(img.height):
    r,g,b = img.getpixel((x,y))
    gray = (r+g+b) // 3
    bw = 0 if gray<bwThreshold else 255
    img.putpixel((x,y), (bw,bw,bw))

display(img)

# red channel
img = getImage(imgUrl)
for x in range(img.width):
  for y in range(img.height):
    r,g,b = img.getpixel((x,y))
    img.putpixel((x,y), (r,0,0))

display(img)

# green channel
# ...

# blue channel
# ...
```

Pro pokročilé:

```python
imgUrl = 'https://i.imgflip.com/2/7nx4qw.jpg'

def filter(img, func):
  """ Makes a copy of the image and applies a filter function."""
  img = img.copy()
  for x in range(img.width):
    for y in range(img.height):
      r,g,b = img.getpixel((x,y))
      r,g,b = func(r,g,b)
      img.putpixel((x,y), (r,g,b))

  return img

img = getImage(imgUrl)
display(img)

# gray scale
def grayFunc(r,g,b):
  gray = (r+g+b) // 3
  return (gray,gray,gray)

# subtractive colours
def cyanFunc(r,g,b):
  return (0,g,b)

def magentaFunc(r,g,b):
  return (r,0,b)

def yellowFunc(r,g,b):
  return (r,g,0)

# negatives
def bwNeg(r,g,b):
  gray = 255 - (r+g+b) // 3
  return (gray,gray,gray)

def clrNeg(r,g,b):
  return (255-r,255-g,255-b)

display(filter(img, grayFunc))
display(filter(img, cyanFunc))
display(filter(img, magentaFunc))
display(filter(img, yellowFunc))

display(filter(img, bwNeg))
display(filter(img, clrNeg))
```

Šachovnice:

```python
# chessboard params
ROWS = 5
COLS = 7
SIZE = 12

# image params
width   = COLS * SIZE
height  = ROWS * SIZEhttps://colab.research.google.com/github/JulesKouatchou/py_data_science/blob/master/introduction_turtle.ipynb
size = (width, height)
img = Image.new('RGB', size)

black = (0,0,0)
white = (255,255,255)

for i in range(width):
  for j in range(height):
    coe = (i//SIZE)%2                  # column odd or even
    roe = (j//SIZE)%2                  # row odd or even
    color = black if roe==coe else white
    img.putpixel((i,j),color)

for i in range(width):
  img.putpixel((i, 0), black)
  img.putpixel((i, height-1), black)

for j in range(height):
  img.putpixel((0, j), black)
  img.putpixel((width-1, j), black)

img
```
