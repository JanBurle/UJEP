# 11 – Práce se soubory

Projděte si také:

## [PB10](https://github.com/pavelberanek91/UJEP/blob/main/APR1/Cvi%C4%8Den%C3%AD%2010/README.md)

> Příprava: nahrajte si soubor `PepaNos.txt` do adresáře souborů na Colab.

Soubor otevřete pro čtení, přečtete obsah a obsah vypíšete (mode='r'):

```python
soubor = open('PepaNos.txt', 'r') # deskriptor
obsah = soubor.read()             # datový proud
soubor.close()
obsah # řetězec s konci řádků \n
```

Pomocí klauzule `with` (tzv. kontextový správce, context manager) zajistíte, že soubor se automaticky zavře, dokonce i když nastane výjimka:

```python
with open('PepaNos.txt', 'r') as soubor:
  obsah = soubor.read()
print(obsah)
```

Co se stane, když soubor neexistuje?

```python
with open('Neznámý.txt', 'r') as soubor:
  obsah = soubor.read()
print(obsah)
```

Ošetření výjimky:

```python
try:
  with open('Neznámý.txt', 'r') as soubor:
    obsah = soubor.read()
except FileNotFoundError:
  obsah = '???'

print(obsah)
```

Soubor lze přečíst jako seznam řádků:

```python
with open('PepaNos.txt', 'r') as soubor:
  obsah = soubor.readlines()
print(obsah)
```

Koncové znaky řádek `\n` (nebo lépe řečeno: bílá místa na konci řádek) lze odstranit:

```python
with open('PepaNos.txt', 'r') as soubor:
  obsah = [line.rstrip() for line in soubor.readlines()]
print(obsah)
```

Při zápisu do souboru (mode='w') se soubor buď vytvoří, nebo přepíše:

```python
with open('Nový.txt', 'w') as soubor:
  soubor.write('první řádka\n')
  soubor.write('druhá řádka\n')
```

Nebo jako seznak řádek:

```python
with open('Nový.txt', 'w') as soubor:
  soubor.writelines([
    'první řádka\n',
    'druhá řádka\n'
  ])
```

Nový soubor lze pak přečíst:

```python
with open('Nový.txt', 'r') as soubor:
  print(soubor.read())
```

Do existujícího souboru lze připisovat (zapisovat na konec):

```python
with open('Nový.txt', 'a') as soubor:
  soubor.write('třetí řádka\n')
```

Soubory lze otevírat (`open()`) i v jiných módech (režimech):

```python
help(open) # přečtěte si dokumentaci
```

Pozici pro čtení/zápis v souboru (čtecí/zápisová "hlava") lze získat i nastavit. Do souboru lze tak zapisovat i číst na libovolném místě:

```python
with open('abc.txt', 'w+') as file:
  print('1.', file.tell())
  file.write('abcdefghijklmnopqrstuvwxyz')
  print('2.', file.tell())
  file.seek(0) # rewind
  print('3.', file.tell())

  while True:
    print(file.tell(), end=' ')
    char = file.read(1)
    if not char: break # empty string (read beyond the file end)
    print(char)

  file.seek(20)
  file.write('XXX')
  file.seek(0)
  print(file.read())
```

```python
help(file.seek) # přečtěte si dokumentaci
```

Délku souboru lze zjistit pomocí metody `tell()`:

```python
with open('abc.txt', 'r') as file:
  file.seek(0, 2)
  print('length:', file.tell())
```

nebo systémovou funkcí:

```python
import os
print('length:', os.path.getsize('abc.txt'))
```

### Shrnutí módů:

| mód | popis                      |
| --- | -------------------------- |
| r   | čtení                      |
| w   | zápis (přepisuje)          |
| a   | přípis                     |
| r+  | čtení a zápis (na začátku) |
| w+  | čtení a zápis (přepisuje)  |
| a+  | čtení a zápis (na konci)   |

Dále je možno příznakem `b` pracovat se souborem tzv. binárně, tj. bajt po bajtu:

| mód | popis                      |
| --- | -------------------------- |
| rb  | čtení binárních dat        |
| wb  | zápis                      |
| ab  | přípis                     |
| rb+ | čtení a zápis (na začátku) |
| wb+ | čtení a zápis (přepisuje)  |
| ab+ | čtení a zápis (na konci)   |

Mohli bychom si např. vytvořit soubor pro uložení obrázku, v našem vlastním nestandardním binárním formátu.

Nejdříve obrázek vytvoříme, zobrazíme a zapíšeme data do souboru:

```python
from PIL import Image

w = 60
h = 48

img = Image.new('RGB', (w,h))

for x in range(w):
  for y in range(h):
    img.putpixel((x,y), (x*4,0,255-x*3))

display(img)

with open('img.bin', 'wb') as file:
  file.write(bytes([w, h]))
  for x in range(w):
    for y in range(h):
      r,g,b = img.getpixel((x,y))
      file.write(bytes([r,g,b]))
```

Obrázek pak můžeme načíst zpět:

```python
with open('img.bin', 'rb') as file:
  w = file.read(1)[0]
  h = file.read(1)[0]
  img = Image.new('RGB', (w,h))
  for x in range(w):
    for y in range(h):
      r = file.read(1)[0]
      g = file.read(1)[0]
      b = file.read(1)[0]
      img.putpixel((x,y), (r,g,b))

display(img)
```

### 📱 Úloha:

Upravte kód pro ukládání a čtení obrázku tak, aby bylo možné uložit a načíst i obrázek větší než 255×255 pixelů.

### 📱 Úloha:

Vezměme slovník, který obsahuje seznamy známek studentů (z dřívějšího cvičení).

```python
známky = {
  'Adam': [1,1,2,1,3,5],
  'Nela': [1,4,2,1,1,2],
  'Zuzi': [1,1,1,1,1,2],
}
```

Zapište tato data do [CSV](https://cs.wikipedia.org/wiki/CSV) souboru `známky.csv`. Každý řádek bude obsahovat jméno studenta a jeho známky oddělené čárkou, takto:

```
Jméno,z1,z2,z3,z4,z5,z6
Adam,1,1,2,1,3,5
Nela,1,4,2,1,1,2
Zuzi,1,1,1,1,1,2
```

**OS10.1: Zápis nahodných známek do CSV souboru**

### 📱 Úloha:

Načtěte známky ze souboru `známky.csv`, uložte je do slovníku a vypište je na obrazovku.

### 📱 Úloha:

Napište funkci, která načte prvních `n` řádků ze souboru `file` (např. `PepaNos.txt`) a vrátí je jako seznam řádků.

```python
def head(file:str, n=10) -> list[str]
  ...

print(head('PepaNos.txt', 3))
```

### 📱 Úloha:

Napište funkci, které je obdobou příkazu [`wc`](https://www.geeksforgeeks.org/wc-command-linux-examples/) (word count) v Linuxu: přečte soubor a vrátí počet řádků, počet slov a počet znaků v souboru.

```python
def wc(file:str) -> tuple[int,int,int]:
  nl = 0; nw = 0; nc = 0
  ...
  return (nl, nw, nc)

print(wc('PepaNos.txt'))
```

### 📱 Úloha:

Přečtěte soubor `PepaNos.txt`. Obsah zapište do souboru `PepaNos-obráceně.txt` tak, aby byl zapsán obráceně (poslední řádek jako první, předposlední jako druhý, atd.).

### 📱 Úloha:

Přečtěte soubor `PepaNos.txt`. Obsah zapište do souboru `PepaNos-číslováno.txt` tak, aby každý řádek v novém souboru obsahoval číslo řádku a text oddělený tečkou. Text řádek, které se v souboru opakují, zapište jen jednou, při prvním výskytu. Další výskyty zapište jako `== (X) == `, kde `X` je číslo řádky s prvním opakováním.

### 📱 Úloha:

Napište funkci, která načte soubor `PepaNos.txt` a vrátí slovník, kde klíčem je slovo a hodnotou je počet výskytů tohoto slova v souboru.

```python
def wordCount(file:str) -> dict[str,int]:
  ...

print(wordCount('PepaNos.txt'))
```

Dále:

- vypište slova a jejich počty seřazené podle a) abecedy, b) počtu výskytů
- pomocí knihovny `matplotlib` vykreslete sloupcový graf, který zobrazí 10 nejčastějších slov
