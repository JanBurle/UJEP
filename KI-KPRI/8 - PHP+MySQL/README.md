# PHP a databáze

Databáze bývá integrální částí webových systémů. V našem projektu je použita standardní SQL databáze, [MySQL](https://www.mysql.com/). Další populární SQL databáze jso např.
* [PostgreSQL](https://www.postgresql.org/)
* [MariaDB](https://mariadb.org/)
* [EdgeDB](https://www.edgedb.com/)

V našem projektu je připraven nástroj na administraci databáze: [Adminer](https://www.adminer.org/). Běží v prohlížeči na URL `localhost:8080`. Přihlašovací údaje a databáze samotná jsou vytvořeny v `compose.yaml`.

### Příklad: vložení dat

Pomocí *adminer* vložte další testovací data.

### Příklad: export dat

Strukturu tabulek a vložená data vyexportujte jako SQL soubor.

## Připojení PHP k databázi (mysqli)

Seznamte se s PHP rozšířením MySQLi: [W3 Schools](https://www.w3schools.com/php/php_ref_mysqli.asp), [PHP Manual](https://www.php.net/manual/en/book.mysqli.php).

MySQLi má duální (procedurální a objektově orientované) rozhraní.

## Select, Insert, Update, Delete

Základní příkazy SQL pro manipulaci s daty jsou:
* [SELECT](https://www.w3schools.com/SQL/sql_select.asp)
* [INSERT](https://www.w3schools.com/SQL/sql_insert.asp)
* [UPDATE](https://www.w3schools.com/SQL/sql_update.asp)
* [DELETE](https://www.w3schools.com/SQL/sql_delete.asp)
