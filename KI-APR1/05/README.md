# 05 – Cykly a úlohy...

#### Nastavení Colab zápisníku

Doporučuji: v menu _Tools / Settings / Editor_ nastavte:

- Show indentation guides
- Případně: indentation width 4

A v menu _Tools / Settings / AI assistance_

- vypněte AI features

## Cykly (smyčky) a obrázky

Obrázky jsou výborný materiál pro procvičování vnořených cyklů. Pro práci s obrázky použijeme modul Python Imaging Library [PIL](https://pythonexamples.org/python-pillow/).

#### Import modulu Image:

```python
from PIL import Image   # modul pro práci s obrázky
```

#### Nový, prázdý obrázek:

```python
width  = 120
height = 80
size = (width, height)  # závorky jsou důležité: dvojice (tuple)

img = Image.new('RGB', size) # nový obrázek, RGB kanály
```

#### Zobrazení:

Na poslední řádce:

```python
img
```

Nebo kdekoli:

```python
display(img)
```

#### Práce s body (pixel = _picture element_) v obrázku:

Čtení:

```python
img.getpixel((10,10))  # černá (0, 0, 0)
```

Zápis:

```python
green = (0,255,0)
img.putpixel((10,10),green)
img
```

Zvětšené obrazení:

```python
img.resize((240, 160))
```

#### Animace

Poněkud neobratná, ale přesto:

```python
from IPython.display import clear_output
from time import sleep

img = Image.new('RGB', (9,9))

for i in range(4):
  clear_output(wait=True)
  img.putpixel((4,4), (255,0,0) if i%2 else (0,255,0))
  display(img.resize((36,36)))
  sleep(1)
```

#### Načtení obrázku

Nahrajte obrázek do záložky Files nalevo v zápisníku. Pak lze obrázek načíst a otevřít:

```python
img = Image.open('PythonLogo.png')
print(img)
print(img.height)
display(img)
```

### 📱 Úlohy:

- Vytvořte prázdný obrázek a

  - vyplňte jej zvolenou barvou
  - namalujte do něj pruhy: vodorovné, svislé, křižující se, apod.

- Načtěte obrázek a aplikujte na něj filtr, který:
  - konvertuje barvy v obrázku na stupnici šedi
  - konvertuje barvy v obrázku na černou a bílou
  - rozloží obrázek na tři "kanály" (složky): červený, zelený, modrý

## Další úlohy na cykly, bez obrázků

- Zjistěte kolik zadaná věta obsahuje písmen a číslic.
- V zadané kolekci čísel najděte minimální a maximální prvek, bez použití funkcí `min()` nebo `max()`.
- Vypište Fibonnaciho posloupnost (její část).
- Vypište Pascalův trojúhelník (jeho část).
- Zjistěte GCD (největší společný dělitel) dvou celých čísel, pomocí Euklidova algoritmu.

## Další, složitější úlohy

- Myslete si číslo mezi 0 a 1023. Váš program vám bude pokládat otázky, na které odpovíte ano/ne. Program by měl vaše číslo uhádnout co nejdříve (nejmenším množství otázek).
- Napište program na určení palindromu, který nekopíruje žádná data ze zadaného řetězce, a který pracuje přímo nad původními daty (in-place/in situ algoritmus).
