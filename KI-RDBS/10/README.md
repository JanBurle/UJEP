# 10 – Programování klientů: Python / PHP

### Psycopg ("psycho" / postgres)

https://www.psycopg.org/docs/

PostgreSQL adapter for Python.

- metody:
  - connect()
  - execute()
- konvertuje data mezi pg/python
- parametrizace dotazů (prevence sql injection)
- podporuje kurzory

```
pip install psycopg
pip install psycopg_binary
```

## [Projekt](../Project)

- [docker compose](../Project/docker-compose.yml)
  - web server, Python
  - postgres, databáze: app, otevřený port pro lokální vývoj, skript pro inicializaci databáze
  - cloudbeaver: pro vývoj

## Code walkthrough

- [init-db](../Project/init)

  - uživatel joe
  - tabulky
  - testovací data
  - triggery
  - funkce a procedury pro Pepu

* Shell: [postgres](../Project/bashpg.sh)

  - `psql -U app-user app`
  - příkazy:
    - help
    - \\?, \\c, \\dt
    - `select * from audit_log;`
    - \\q
  - ^D

* Shell: [webserver](../Project/bashws.sh)

  - mc
  - python3 <file.py>
  - ^D

- [Python](../Project/src)

  - `1 - test.py`: test connect() + execute()
  - `2 - show-log.py`: select \* from audit_log, sql injection
  - `3 - weather-select.py`: select \* from weather, select <function()>
  - `4 - weather-insert.py`: insert into weather, transaction
  - `5 - pyqt.py`: Qt application

- [PHP](../Project/www)
  - `index.php`: web page
