# 11 – ORM: Object-Relational Mapping

Databáze:

1. Relační databáze, RDB(M)S
2. Objektové databáze, O(O)DB(M)S
3. Objektově-relační mapování, ORM

## 1. Relační databáze, RDB(M)S

- Relational Database Management Systems
- orientované na tabulky a relace

### Pre-SQL

Programovací jazyk s integrovanou databází.

- dBase III

```
USE WEATHER
SET FILTER TO CityId = "ul"
GO TOP
DO WHILE .NOT. EOF()
    ? Date, TempLo, TempHi
    SKIP
ENDDO
```

- Progress 4GL

```
FOR EACH Weather WHERE Weather.CityId = "ul":
    DISPLAY Weather.Date Weather.TempLo Weather.TempHi.
END.
```

### SQL

- 1974 – IBM Research, SEQUEL
  - _manipulace mnoha záznamů najednou_
- 1980 – SQL použit firmou Relational Software, dnes Oracle
- 1986 – první standard SQL-86

### QBE – Query By Example

Grafické rozhraní pro tvorbu SQL dotazů.

- ~1990 – Paradox/DOS, Borland

#### SQL

```sql
select c.name as city, w.date as date, w.temp_lo as lo, w.temp_hi as hi
from city c join weather w on c.id = w.city_id order by c.name, w.date
where c.id = 'at' and w.date >= '2004-11-01';
```

#### QBE

| **City** | id   | name |
| -------- | ---- | ---- |
| Name     |      | city |
| Show     |      | ✔    |
| Criteria | 'at' |      |
| Join     | id   |      |
| Sort     |      | ✔    |

| **Weather** | city_id | temp_lo | temp_hi | date            |
| ----------- | ------- | ------- | ------- | --------------- |
| Name        |         | lo      | hi      | date            |
| Show        |         | ✔       | ✔       | ✔               |
| Criteria    |         |         |         | >= '2004-11-01' |
| Join        | id      |         |         |                 |
| Sort        |         |         |         | ✔               |

## 2. Objektové databáze, ODB(M)S

- Object(-Oriented) Database Management Systems
- _transparetní_ persistence pro objekty v OO jazycích: Perl, Ruby, Smalltalk, Python ...

- 1966 – předchůdce: [MUMPS](https://en.wikipedia.org/wiki/MUMPS), vestavěná databáze
- ~1990 – první generace:
  - [ObjectStore](https://en.wikipedia.org/wiki/ObjectStore), C++
  - [Gemstone](https://en.wikipedia.org/wiki/GemStone/S), SmallTalk, Java
  - [ZODB](https://en.wikipedia.org/wiki/Zope_Object_Database), Python
- ~2000 – druhá generace

#### ObjectStore

```cpp
#include <os_....h>

class City : public os_persistent {
public:
    os_char *id;
    os_char *name;

    City(char const* id, char const* name) {
        this->id   = os_strdup(id);
        this->name = os_strdup(name);
    }

    ~City() {
        os_free(id);
        os_free(name);
    }

    void print() {
        ...
    }
};

void writeDb(os_database *db) {
    os_transaction::begin(os_transaction::update);

    auto city = new(db, "city") os_collection<City*>();
    city->insert(new(db) City("mo", "Most"));
    city->insert(new(db) City("bi", "Bílina"));

    os_transaction::commit();
}

void readDb(os_database *db) {
    os_transaction::begin(os_transaction::read_only);

    auto city = db->lookup<os_collection<City*>>("city");
    for (auto it = city->begin(); it != city->end(); ++it) {
        (*it)->print();
        ...
    }

    os_transaction::commit();
}

int main() {
    os_initialize();

    auto db = os_database::open("city.db", 0, 0644)
    write_data(db);
    read_data(db);

    db->close();
    os_finalize();

    return 0;
}
```

#### ZODB

```python
!pip install ZODB
!pip install persistent
!pip install transaction
```

```python
from ZODB import FileStorage, DB
from persistent import Persistent
import transaction

class City(Persistent):
  def __init__(self, id, name):
    self.id = id
    self.name = name

  def __repr__(self):
    return f"City(id='{self.id}', name='{self.name}')"

class Weather(Persistent):
  def __init__(self, city_id, temp_lo, temp_hi, date):
    self.city_id = city_id
    self.temp_lo = temp_lo
    self.temp_hi = temp_hi
    self.date = date

  def __repr__(self):
    return f"Weather(city_id='{self.city_id}', temp_lo={self.temp_lo}, temp_hi={self.temp_hi}, date={self.date})"
```

```python
def writeDb():
  storage = FileStorage.FileStorage('weather.fs')
  db = DB(storage)
  connection = db.open()
  root = connection.root()

  try:
    transaction.begin()

    for coll in ['city', 'weather']:
      if coll not in root: root[coll]  = {}

    collCity = root['city']
    collCity['mo'] = City('mo', 'Most')
    collCity['bi'] = City('bi', 'Bílina')

    collWeather = root['weather']
    collWeather[('mo', '2023-10-01')] = Weather('mo', 10, 20, '2023-10-01')
    collWeather[('bi', '2023-10-01')] = Weather('bi', 12, 22, '2023-10-01')

    transaction.commit()

  finally:
    connection.close()
    db.close()

writeDb()
```

```python
def readDb():
  storage = FileStorage.FileStorage('weather.fs')
  db = DB(storage)
  connection = db.open()
  root = connection.root()

  try:
    transaction.begin()

    print(root)

    for city in root['city'].values():
      print(city)

    for weather in root['weather'].values():
      print(weather)

    transaction.commit()

  finally:
    connection.close()
    db.close()

readDb()
```

## 3. Objektově-relační mapování

- Konverze dat mezi objektovým a relačním modelem.
- OO programovací jazyk 🠈 ORM 🠊 RDBS
- To nejlepší z obou světů: flexibilní objektový model a výkonná relační databáze.

ORM je abstrakce nad SQL, která umožňuje pracovat s databází pomocí objektů.

### Proč ORM?:

- Relační databáze zvítězily. Jsou výkonné, optimalizované, široce používané. Jazyky jsou OO: je zde _impedance mismatch_.

### Kritika:

- Netěsná, děravá (leaky) abstrakce.
- Nízký výkon, vinou nadbytečných dotazů.
- Složitost. Není jednoduché synchronizovat objekty v paměti / tabulky v databázi, je to těžký, netriviální problém. ORM není lehké se naučit.
- Impedance mismatch: objects (OO) / tuples (RDBS).
- Problematické není tolik mapování objektů a relací, ale mapování dat v paměti a dat v databázi. Změna na jedné straně - jak ji přenést na druhou stranu?
- Velká očekávání, disiluze.
- ORM má tendenci být bloatware.

### Kacířské názory:

- Je lépe si "ubalit svoje vlastní" ORM.
- Alespoň ro změny v databázi je lepší použít SQL: tedy ORM pro čtení, SQL pro zápis.

### Závěr:

- Zvolit podle aplikace:
  - pokud jsou data jsou více-méně relační, nepoužívejte ORM, pokud jsou grafová, ano
  - pokud je aplikace jednoduchá, nepoužívejte ORM, pokud je složitá, a je potřeba podporovat vícero RDBS, ano

### Vzestup a pád ORM:

![Gartner Hype Cycle](https://en.wikipedia.org/wiki/Gartner_hype_cycle#/media/File:Gartner_Hype_Cycle.svg)
![Gartner Hype Cycle](https://en.wikipedia.org/wiki/Gartner_hype_cycle#/media/File:Hype-Cycle-General.png)

[1996: Object-Relational DBMSs, The next great wave](https://archive.org/details/objectrelational0000ston)

### ORM software:

(Seznam)[https://en.wikipedia.org/wiki/List_of_object%E2%80%93relational_mapping_software]

## SQLAlchemy

Dvě části: Core a ORM

#### Core

Abstrakce nad různými RDBS, místo psaní SQL: výrazy v Pythonu

#### ORM (Object Relational Mapper)

Práce s třídami a objekty v Pythonu: interakce s tabulkami v databázi.

SQLAlchemy

- podporuje řadu databází a adaptérů
- netěsná abstrakce: `text()`
- každá třída je reprezentovaná tabulou

* [definice dat](./alchemy/mydb.py)
* [zápis](./alchemy/write.py)
* [čtení](./alchemy/read.py)
