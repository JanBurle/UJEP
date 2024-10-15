# 03 – Vnořený SELECT, analytické funkce (windows functions)

Window functions, česky analytické funkce

- umožňují doplňovat běžné řádky o souhrné informace získané z jiných řádků
- používají se v sekci SELECT
  - na rozdíl od běžných funkcí pracují nad více řádky (proto "window")
  - podobají se agregacím pomocí GROUP BY ale nevedou k redukci řádků
- některé lze emulovat pomocí vnořených dotazů uvnitř sekcí SELECT

Viz:

- [PostgreSQL Window Tutorial](https://www.postgresql.org/docs/current/tutorial-window.html)

* [PostgreSQL Window Functions](https://www.postgresql.org/docs/current/functions-window.html)
* [Skripta, kap.1](https://ki.ujep.cz/opory/Informatika/Bc_Informatika_pro_vzdelavani/Relacni_databazove_systemy.docx)\*\*

## Praktická ukázka

Připravte tabulky a data:

- [Mordorský maratón](./mormar.sql)\*\*

### Vnořený SELECT:

Dotazy (SELECT), které vypíší účastníky maratónu, a u každého:

#### kdo doběhl těsně před ním

```sql
-- účastníci
select závodník from mormar;

-- poslední, který měl lepší než zadaný čas
select závodník, čas from mormar
  where čas < '01:56:00'
  order by čas desc
  limit 1;

-- závodník a kdo doběhl těsně před ním
select závodník, (select závodník from mormar
                  where čas < m.čas
                  order by čas desc limit 1)
  from mormar m;
```

#### kdo doběhl těsně před ním ve stejné kategorii

```sql
select závodník, (select závodník from mormar
                  where kategorie=m.kategorie and čas<m.čas
                  order by čas desc limit 1)
  from mormar m;
```

#### kolik každý ztratil na vítěze

```sql
select závodník,
        čas - (select čas from mormar
               order by čas asc limit 1)
  from mormar;
```

#### kolik každý ztratil na vítěze ve své kategorii

```sql
select závodník,
        čas - (select čas from mormar
               where kategorie=m.kategorie
               order by čas asc limit 1)
  from mormar m;
```

#### kolikátý doběhl

```sql
select závodník, (select count(*) from mormar where čas < m.čas)
  from mormar m;
```

#### kolikátý doběhl ve své kategorii

```sql
select závodník, 1 + (select count(*) from mormar
        where kategorie=m.kategorie and čas < m.čas)
  from mormar m;
```

#### kolik závodníků doběhlo za ním

```sql
select závodník, (select count(*) from mormar
                           where m.čas < čas), 0)
  from mormar m;
```

### Analytické funkce:

#### jak fungují

```sql
-- select
select kategorie, čas from mormar order by kategorie;

-- agregace (GROUP BY)
select kategorie, avg(čas) from mormar
  group by kategorie order by kategorie;

select kategorie, avg(čas) from mormar
  group by kategorie order by avg(čas);

-- analytické funkce
select kategorie, čas, avg(čas) over ()
  from mormar order by kategorie;

select kategorie, čas, avg(čas) over (partition by kategorie)
  from mormar order by kategorie;

select kategorie, čas,
       rank() over (order by čas),
       row_number() over ()
  from mormar order by kategorie;
```

#### kdo doběhl těsně před ním

```sql
select závodník,
       (select závodník from mormar
        where čas < m.čas order by čas desc limit 1)
  from mormar m order by čas;

select závodník, lag(závodník) over (order by čas)
  from mormar order by čas;
```

#### kdo doběhl těsně před ním ve stejné kategorii

vnořený SELECT (pro srovnání), window function:

```sql
select kategorie, závodník,
       (select závodník from mormar
        where kategorie=m.kategorie and čas<m.čas
        order by čas desc limit 1)
  from mormar m order by kategorie, čas;

select kategorie, závodník,
       lag(závodník) over (partition by kategorie
                           order by čas)
  from mormar order by kategorie, čas;
```

#### kolik každý ztratil na vítěze

```sql
select závodník,
        čas - (select čas from mormar
               order by čas asc limit 1)
  from mormar order by čas;

select závodník, čas - first_value(čas) over (order by čas)
  from mormar order by čas;
```

#### kolik každý ztratil na vítěze ve své kategorii

```sql
select závodník,
        čas - (select čas from mormar
               where kategorie=m.kategorie
               order by čas asc limit 1)
  from mormar m order by kategorie, čas;

select kategorie, závodník,
       čas - first_value(čas) over (partition by kategorie
                                    order by čas)
  from mormar order by kategorie, čas;
```

#### kolikátý doběhl

```sql
select závodník, 1 + (select count(*) from mormar
                      where čas < m.čas)
  from mormar m order by čas;

select závodník, rank() over (order by čas)
  from mormar m order by čas;
```

#### kolikátý doběhl ve své kategorii

```sql
select závodník, 1 + (select count(*) from mormar
        where kategorie=m.kategorie and čas < m.čas)
  from mormar m order by kategorie, čas;

select kategorie, závodník,
       rank() over (partition by kategorie order by čas)
  from mormar m order by kategorie, čas;
```

#### kolik závodníků doběhlo za ním

```sql
select závodník, (select count(*) from mormar
                  where m.čas < čas)
  from mormar m order by čas;

select závodník, rank() over (order by čas desc) - 1
  from mormar m order by čas;
```

---

## Pokračování z lekce 02: referenční integrita a integrita dat

#### Databáze se musí umět ubránit špatným datům!

Tabulky `city`, `weather` s klíči, indexy a validací (omezením) dat, tři verze:

- [Klíče, unikátní index, omezení](./weather-1.sql)
- [Jednodušší, modernější syntaxe, přidán cizí klíč](./weather-2.sql)
- [Zjednodušená syntaxe](./weather-3.sql)
- [Vložení dat](./weather-insert.sql)

JOIN a WHERE nyní používají indexovaná pole:

```sql
SELECT * FROM city;
SELECT * FROM weather;
SELECT * FROM city, weather;

SELECT * FROM city, weather WHERE id = city_id;
SELECT name, temp_lo as lo, temp_hi as hi FROM city, weather WHERE id = city_id;

SELECT * FROM city JOIN weather ON id = city_id;

SELECT * FROM city LEFT JOIN weather ON id = city_id;
SELECT * FROM city RIGHT JOIN weather ON id = city_id; -- zde stejné jako inner join!
```

### Mazání záznamů se závislými záznamy:

Nelze:

- [ON DELETE NO ACTION](./weather-no-action.sql) (default)
- [ON DELETE RESTRICT](./weather-restrict.sql)

Lze:

- [ON DELETE CASCADE](./weather-cascade.sql)

Ale pak pozor:

```sql
DELETE FROM city; -- POOF! Obě tabulky vyprázdněné.
```
