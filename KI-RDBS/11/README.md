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

#### MUMPS

```
; MUMPS Code for Managing Patient Data

START ;
    ; Add patients to the global variable
    D ADDPATIENT("John Doe", 45, "Hypertension")
    D ADDPATIENT("Jane Smith", 38, "Diabetes")
    D ADDPATIENT("Alice Brown", 29, "Asthma")

    ; Display patient data
    D SHOWPATIENTS

    ; Update a patient's diagnosis
    D UPDATEPATIENT("John Doe", "Hypertension", "High Blood Pressure")

    ; Display updated patient data
    D SHOWPATIENTS

    Q

ADDPATIENT(NAME, AGE, DIAGNOSIS) ;
    ; Adds patient information to the global variable ^PATIENTS
    ; Global format: ^PATIENTS(PatientID, "Name") = Name
    ;               ^PATIENTS(PatientID, "Age") = Age
    ;               ^PATIENTS(PatientID, "Diagnosis") = Diagnosis
    NEW PATIENTID,GLOBAL
    SET PATIENTID=$O(^PATIENTS(""),-1)+1  ; Create a new unique patient ID
    SET ^PATIENTS(PATIENTID,"Name")=NAME
    SET ^PATIENTS(PATIENTID,"Age")=AGE
    SET ^PATIENTS(PATIENTID,"Diagnosis")=DIAGNOSIS
    QUIT

SHOWPATIENTS ;
    ; Display all patient information
    NEW PATIENTID
    SET PATIENTID=0
    FOR  SET PATIENTID=$O(^PATIENTS(PATIENTID)) QUIT:PATIENTID=""  DO
    . WRITE !,"Patient ID: ",PATIENTID
    . WRITE !,"Name: ",^PATIENTS(PATIENTID,"Name")
    . WRITE !,"Age: ",^PATIENTS(PATIENTID,"Age")
    . WRITE !,"Diagnosis: ",^PATIENTS(PATIENTID,"Diagnosis")
    . WRITE !!
    QUIT

UPDATEPATIENT(NAME, OLD_DIAGNOSIS, NEW_DIAGNOSIS) ;
    ; Updates the diagnosis of a specific patient
    NEW PATIENTID
    SET PATIENTID=0
    FOR  SET PATIENTID=$O(^PATIENTS(PATIENTID)) QUIT:PATIENTID=""  DO
    . IF ^PATIENTS(PATIENTID,"Name")=NAME, ^PATIENTS(PATIENTID,"Diagnosis")=OLD_DIAGNOSIS DO
    . . SET ^PATIENTS(PATIENTID,"Diagnosis")=NEW_DIAGNOSIS
    . . WRITE "Updated ", NAME, "'s diagnosis to: ", NEW_DIAGNOSIS, !
    QUIT
```

```yaml
Patient ID: 1
Name: John Doe
Age: 45
Diagnosis: Hypertension

Patient ID: 2
Name: Jane Smith
Age: 38
Diagnosis: Diabetes

Patient ID: 3
Name: Alice Brown
Age: 29
Diagnosis: Asthma

Updated John Doe's diagnosis to: High Blood Pressure

Patient ID: 1
Name: John Doe
Age: 45
Diagnosis: High Blood Pressure

Patient ID: 2
Name: Jane Smith
Age: 38
Diagnosis: Diabetes

Patient ID: 3
Name: Alice Brown
Age: 29
Diagnosis: Asthma
```

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
```

Definice dat:

```python
from persistent import Persistent

class City(Persistent):
  def __init__(self, id, name):
    # no need to call: super().__init__()
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

Zápis:

```python
from ZODB import FileStorage, DB
import transaction
from mydb import *

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
```

Čtení:

```python
from ZODB import FileStorage, DB
import transaction
from mydb import *

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
```

## 3. Objektově-relační mapování

- Konverze dat mezi objektovým a relačním modelem.
- OO programovací jazyk 🠈 ORM 🠊 RDBS
- To nejlepší z obou světů: flexibilní objektový model a výkonná relační databáze.

ORM je abstrakce nad SQL, která umožňuje pracovat s databází pomocí objektů.

### Proč ORM?:

- Relační databáze zvítězily. Jsou výkonné, optimalizované, široce používané. Jazyky jsou OO: je zde _impedance mismatch_. ORM se to snaží vyřešit.

### Kritika:

- Netěsná, děravá (leaky) abstrakce.
- Nízký výkon, vinou nadbytečných dotazů.
- Složitost. Není jednoduché synchronizovat objekty v paměti / tabulky v databázi. Je to těžký, netriviální problém. ORM není lehké se naučit.
- _Impedance mismatch_ – objects (OO) / tuples (RDBS) – nelze snadno překonat.
- Problematické není ani tolik mapování objektů a relací, ale mapování dat v paměti a dat v databázi. Změna na jedné straně - jak a kdy ji přenést na druhou stranu? (Multi-processing)
- Velká očekávání, částečná disiluze.
- ORM a aplikace používající ORM mají tendenci se stát bloatwarem.

### Kacířské názory:

- Je lépe si "ubalit svoje vlastní" ORM.
- Alespoň pro změny v databázi je lepší použít SQL: tedy ORM pro čtení, SQL pro zápis.

### Vzestup a pád ORM:

[Gartner Hype Cycle](https://en.wikipedia.org/wiki/Gartner_hype_cycle)

1996: [Object-Relational DBMSs, The next great wave](https://www.amazon.com/Object-Relational-DBMSs-Kaufmann-Management-Systems/dp/1558603972)

2006: [Object-Relational Mapping is the Vietnam of Computer Science](https://blog.codinghorror.com/object-relational-mapping-is-the-vietnam-of-computer-science/)

### Použít ORM nebo ne?

- Zvolit podle aplikace:
  - pokud jsou data jsou více-méně relační, použijte RDBS
  - pokud jsou data objektová/grafová
    - pokud jsou jednoduchá, použijte RDBS a vlastní mapování
    - pokud jsou složitá, použijte ODBS/ORM
  - pokud je potřeba podporovat vícero RDMBS, použijte ORM jako SQL abstrakci

To jest, zvažte možnosti:

- vzdát se objektů
- vzdát se tabulek
- mapovat ručně
- akceptovat (a žít v hranicích) omezení ORM

### ORM software:

[Seznam](https://en.wikipedia.org/wiki/List_of_object%E2%80%93relational_mapping_software)

## SQLAlchemy

Dvě části: Core a ORM

#### Core

Abstrakce nad různými RDBS, místo psaní SQL: výrazy v Pythonu

#### ORM (Object Relational Mapper)

Práce s třídami a objekty v Pythonu: interakce s tabulkami v databázi.

- podporuje řadu databází a adaptérů
- každá třída je reprezentovaná tabulou
- netěsná abstrakce: `text()`

```python
!pip install SQLAlchemy
```

Definice dat, Core:

```python
from sqlalchemy import Column, ForeignKey, CheckConstraint
from sqlalchemy import String, Integer, Date
from sqlalchemy.orm import declarative_base, relationship

from datetime import date

# The base of all mapped classes
Base = declarative_base()

class City(Base):
  __tablename__ = 'city2'
  id      = Column(String(2), primary_key=True)
  name    = Column(String(80), nullable=False)
  weather = relationship("Weather", back_populates="city")

class Weather(Base):
  __tablename__ = 'weather2'
  city_id = Column(String(2), ForeignKey('city2.id'), primary_key=True) # leaky
  temp_lo = Column(Integer, nullable=False)
  temp_hi = Column(Integer, nullable=False)
  date    = Column(Date, primary_key=True, default=date.today)
  city    = relationship("City", back_populates="weather")
  __table_args__ = (
    CheckConstraint('temp_lo <= temp_hi', name='check_temp'),
  )

DB_URL = 'sqlite:///example.db'
# DB_URL = 'postgresql+psycopg://app-user:app-pwd@localhost:5432/app'
```

Zápis:

```python
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from mydb import *

engine = create_engine(DB_URL, echo=True)

# create tables
Base.metadata.create_all(engine)

# database connection
Session = sessionmaker(bind=engine)

with Session() as session:
  import random
  from datetime import date, timedelta

  for id1 in range(ord('a'), ord('d') + 1):
    for id2 in range(ord('a'), ord('d') + 1):
      city_id = chr(id1) + chr(id2)
      city_name = 'City ' + city_id.upper()
      city = City(id=city_id, name=city_name)
      session.add(city) # !!!

      for days in range(7):
        temp_lo = random.randint(0, 30)
        temp_hi = temp_lo + random.randint(0, 10)
        weather_date = date.today() - timedelta(days=days)
        weather = Weather(city_id=city_id, temp_lo=temp_lo, temp_hi=temp_hi, date=weather_date)
        session.add(weather) # !!!

  session.commit() # !!!
```

Čtení:

```python
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from mydb import *

engine = create_engine(DB_URL, echo=True)

# database connection
Session = sessionmaker(bind=engine)

with Session() as session:
  for city in session.query(City.id,City.name).all():
    print(city)
    print(f"City: {city.name}")

  for city in session.query(City).filter_by(id='at').all():
    print(city)
    print(city.__dict__)
    print(f"City: {city.name}")
    for weather in city.weather: # !!!
      print(weather)
      print(f"  Weather: {weather.date}, Low: {weather.temp_lo}, High: {weather.temp_hi}")

  for city in session.query(City).all():
    print(f"City: {city.name}")
    for weather in city.weather: # !!!
      print(f"  Weather: {weather.date}, Low: {weather.temp_lo}, High: {weather.temp_hi}")
```
