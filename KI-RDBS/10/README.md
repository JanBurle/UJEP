# 10 – Programování klientů: Python

### Psycopg ("psycho" / postgres)

https://www.psycopg.org/docs/

PostgreSQL adapter for Python.

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
    - help
    - \\?
      - \\c
      - \\dt
    - `select * from audit_log;`
    - \\q
  - ^D

- [Python](../Project/src)
  - [pg.py](../Project/src/pg.py)

* Shell: [webserver](../Project/bashws.sh)

  - mc
  - python3 1...
  - ^D

* VSCode: src
  - Python debugger
  - 1 - test: version
  - 2 - show-log:
    - fetch all
    - iterate rows
    - iterate selected columns
    - SQL injection
  - 3 - weather-select:
    - app-user / joe x select
    - joe select_weather()
  - 4 - weather-insert:
    - last insert log
    - delete from weather¨
    - implicit transaction
    - explicit transaction
