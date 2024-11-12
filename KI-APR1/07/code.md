#### Počet samohlásek

Vypočítejte seznam dvojic `(jméno, počet samohlásek ve jméně)`. Jména jsou zadaná v připraveném seznamu.

````python
jména = [
    "Pavel Douša", "Milan Nguyen:::",
    "Alena Zábranská", "Rostislav Chrabrý"
]
samohlásky = 'aeiouáéíóúů'
výsledek = []

for jméno in jména:
  cnt = 0
  for písmeno in jméno.lower():
    if písmeno in samohlásky:
      cnt += 1

  výsledek.append((jméno, cnt))

print(f'{výsledek=}')```
````

#### Přihlašovací systém

Napište program, který požádá uživatele o login a heslo.

Program následně zkontroluje, zda se zadaná dvojice `(login, heslo)` nachází v seznamu registrovaných uživatelů. Pokud ano, program vypíše zprávu o úspěšném přihlášení.

Pokud ne, tak program zjistí, zda se v seznamu nachází alespoň login. Pokud ano, tak vypíše zprávu o nesprávném heslu.

Pokud se v seznamu login nenachází, tak program uživateli umožní se zaregistrovat: přidá se zadaný login a heslo mezi registrované uživatele.

```python
# Přihlašovací systém
users = [('Pavel', '1234'), ('Zbyněk', 'heslo')]

def login(name, pwd):
  # sanity check
  name = name.strip()
  pwd  = pwd.strip()
  if not name or not pwd:
    print('bad input')
    return

  # loop through accounts
  for account in users:
    acctName,acctPwd = account
    if name==acctName:
      if pwd==acctPwd:
        print(name, 'logged in')
        return
      else:
        print('bad password')
        return

  print('new account:', name)
  users.append((name, pwd))

# test
login('', ' ')
login('Pavel', '1234')
login('Zbyněk', '1234')
login('Šimon', 'xyz')
login('Šimon', 'xyz')
```

#### Šibenice

Naprogramujte konzolovou verzi hry šibenice. Zadaný je řetězec - tajenka (slovo nebo fráze), kterou hráč nevidí. Místo něj na počátku na obrazovce vidí pouze podtržítka. Hra hráče požádá o zvolené písmeno. Pokud toto písmeno bylo už hádáno, hra požádá o jiné písmeno. Pokud hráč písmeno ještě nehádal, tak program zjistí, zda se písmeno v tajence nachází. Pokud ne, tak hráčovi ubere život. Pokud ano, tak místo podtržítka zobrazí uhádnuté písmeno. Hra končí, když hráč uhádne tajenku, nebo když mu dojdou životy.

```python
# Šibenice
from IPython.display import clear_output
from time import sleep

# tajenka
secret = 'Komu se nelení, tomu se zelení!'

# uhodnutá písmena
guessedChars = set()

# životy
lifes = 6

def printSolution() -> bool:
  """Vypíše současné řešení. Vrátí True, pokud je řešení kompletní."""
  isSolved = True
  for char in secret:
    show = not char.isalpha() or char.lower() in guessedChars
    print(char if show else '_', end='')
    isSolved = isSolved and show
  print()
  return isSolved

def guessChar(char):
  """Hádá se písmeno. Vrátí False když hráč ztrácí život."""
  # sanity
  char = char.strip()
  if not char.isalpha() or 1!=len(char):
    print('Hádejte jedno písmeno!')
    sleep(3)
    return True

  assert char.islower()

  # hádáme
  if char in guessedChars:
    print('Toto písmeno již bylo!')
    sleep(3)
    return True # already guessed

  if secret.lower().count(char): # correctly guessed
    guessedChars.add(char)
    return True

  return False

def askInput():
  life = 'životy' if lifes in [2,3,4] else 'život' if lifes in [1] else 'životů'

  print(f'Máte {lifes} {life}.')
  return input('Jaké písmeno hádáte?')

while 0 < lifes:
  clear_output()
  if printSolution(): break
  if not guessChar(askInput().lower()):
    print('Au, to bolí...')
    sleep(3)
    lifes -= 1

print('Bezva.' if lifes else 'Jau.')
```

#### Hráči

Mějme seznam hráčů a jejich skóre v turnaji:

1. Vypište jméno nejlepšího a nejhoršího hráče (podle skóre).
2. Vypište hráče v pořadí od nejlepšího po nejhoršího.
3. Vypište nejlepší 3 (top-3) hráče.

```python
hráči = [("Pavel", 5), ("Honza", 3), ("Jana", 7), ("Milan", 4), ("Michaela", 9)]

# třídit podle druhého pole
def keyField(hráč):
  return hráč[1]

hráči.sort(key=keyField, reverse=True)

print('1.', hráči[0], hráči[-1])
print('2.', hráči)
print('3.', hráči[:3])
```
