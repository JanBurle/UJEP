# 05 – (Full)textové vyhledávání

[PostgreSQL Ch.12](https://www.postgresql.org/docs/current/textsearch.html)

## Textový dokument

### Vyhledávání

### Předzpracování

## PostgreSQL

### tsvector, tsquery

### Dotazy

## PostgreSQL – podpora jazyků

```sql
SELECT cfgname FROM pg_ts_config;
```

### Instalace podpory pro češtinu

- https://github.com/char0n/postgresql-czech-fulltext
- https://postgres.cz/wiki/Instalace_PostgreSQL#Instalace_Fulltextu

* ´bash.cz´: otevřít shell (terminál) v kontejneru
* ´czech.cz´: nahrát slovník
  - ´czech.dict´: 300 000 řádek (Burle)
  - ´czech.affix´: koncovky
  - ´czech.stop´: stop words

```sql
SELECT cfgname FROM pg_ts_config;
```

## Příklad

### Textový soubor, import

### Dotazy

### Indexace

### Dotazy

###

###
