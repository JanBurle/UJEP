#### Počet samohlásek

Vypočítejte seznam dvojic `(jméno, počet samohlásek ve jméně)`. Jména jsou zadaná v připraveném seznamu.

Jednoduché řešení:

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

Stejné řešení pomocí funkce:

```python
def countWovels(s: str) -> int:
  """Count vowels in s"""
  wovels = 'aáeéiíoóuúůyý'
  cnt = 0
  for char in s.lower():
    if char in wovels:
      cnt += 1

  return cnt

# a list of names
names = [
    "Pavel Douša", "Milan Nguyen:::",
    "Alena Zábranská", "Rostislav Chrabrý"
]

# the result
result = []
for name in names:
  result.append((name, countWovels(name)))

print(f'{result=}')
```

#### Přihlašovací systém

Napište program, který požádá uživatele o login a heslo.

Program následně zkontroluje, zda se zadaná dvojice `(login, heslo)` nachází v seznamu registrovaných uživatelů. Pokud ano, program vypíše zprávu o úspěšném přihlášení.

Pokud ne, tak program zjistí, zda se v seznamu nachází alespoň login. Pokud ano, tak vypíše zprávu o nesprávném heslu.

Pokud se v seznamu login nenachází, tak program uživateli umožní se zaregistrovat: přidá se zadaný login a heslo mezi registrované uživatele.

Řešení s jednou funkcí:

```python
# existing accounts (user name, password)
users = [('Pavel', '1234'), ('Zbyněk', 'heslo')]

def login(name, pwd):
  # sanity check - reject bad input
  name = name.strip()
  pwd  = pwd.strip()
  if not name or not pwd:
    print('bad input')
    return

  # loop through accounts
  for account in users:
    acctName,acctPwd = account
    if name==acctName:  # match the user name
      if pwd==acctPwd:  # match the password
        print(name, 'logged in')
        return
      else:
        print('bad password')
        return

  print('new account:', name)
  users.append((name, pwd))

# test data
login('', ' ')
login('Pavel', '1234')
login('Zbyněk', '1234')
login('Šimon', 'xyz')
login('Šimon', 'xyz')
```

Řešení s více funkcemi:

```python
# existing accounts (user name, password)
users = [('Pavel', '1234'), ('Zbyněk', 'heslo')]

def checkLogin(name:str, pwd:str) -> bool:
  """Check if name/pwd exists in users."""
  return (name,pwd) in users

def checkName(name:str) -> bool:
  """Check if name exists in users."""
  for userName,pwd in users:
    if userName == name:
      return True
  return False

def addUser(name:str, pwd:str):
  """Add name/pwd to users."""
  users.append((name, pwd))

def login(name:str, pwd:str):
  # sanity check
  name = name.strip()
  pwd  = pwd.strip()
  if not name or not pwd:
    print('bad input')
    return

  if checkLogin(name,pwd): # successfully logged in
    print(name, 'logged in')
    return

  if checkName(name):      # found name, but not password
    print('bad password')
    return False

  # found neither name nor password
  print('new account:', name)
  addUser(name, pwd)

# test
login('', ' ')
login('Pavel', '1234')
login('Zbyněk', '1234')
login('Šimon', 'xyz')
login('Šimon', 'xyz')
```

Vylepšení: použit slovník (dictionary):

```python
# existing accounts: user name => password
users = {'Pavel': '1234', 'Zbyněk': 'heslo'}

def checkLogin(name:str, pwd:str) -> bool:
  """Check if name/pwd exists in users."""
  return users.get(name) == pwd

def checkName(name:str) -> bool:
  return name in users

def addUser(name:str, pwd:str):
  users[name] = pwd

def login(name:str, pwd:str):
  """Handle login or account creation."""
  # sanitize input
  name, pwd = name.strip(), pwd.strip()
  if not name or not pwd:
    print('Bad input: name or password is empty.')
    return

  if checkLogin(name,pwd): # successfully logged in
    print(f'User {name} logged in.')
    return

  if checkName(name):      # found name, but not password
    print('Bad password.')
    return False

  # found neither name nor password: new account
  print(f'New account created for {name}.')
  addUser(name, pwd)

# test cases
login('', ' ')
login('Pavel', '1234')
login('Zbyněk', '1234')
login('Šimon', 'xyz')
login('Šimon', 'xyz')
```

#### Šibenice

Naprogramujte konzolovou verzi hry šibenice. Zadaný je řetězec - tajenka (slovo nebo fráze), kterou hráč nevidí. Místo něj na počátku na obrazovce vidí pouze podtržítka. Hra hráče požádá o zvolené písmeno. Pokud toto písmeno bylo už hádáno, hra požádá o jiné písmeno. Pokud hráč písmeno ještě nehádal, tak program zjistí, zda se písmeno v tajence nachází. Pokud ne, tak hráčovi ubere život. Pokud ano, tak místo podtržítka zobrazí uhádnuté písmeno. Hra končí, když hráč uhádne tajenku, nebo když mu dojdou životy.

```python
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
    showIt = not char.isalpha() or char.lower() in guessedChars
    print(char if showIt else '_', end='')
    isSolved = isSolved and showIt
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
  return input('Jaké písmeno hádáte? ')

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
