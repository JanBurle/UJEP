<!-- # 11 – Správa uživatelů

https://www.postgresql.org/docs/17/user-manag.html

Skupiny uživatelů (role)

```sql
create role name;
select rolname from pg_roles;
drop role name;
```

```sql
create role joe login;
create role admin;
create role wheel;
create role island;
grant admin to joe with inherit true;
grant wheel to admin with inherit false;
grant island to joe with inherit true, set false;
SET ROLE joe;
SET ROLE NONE;
RESET ROLE;
```

Předdefinované role: pg_read_all_data, pg_write_all_data,

Práva

```
ALTER TABLE bobs_table OWNER TO alice;
GRANT pg_signal_backend TO admin_user;
GRANT ALL PRIVILEGES ON kinds TO manuel;
GRANT INSERT ON films TO PUBLIC;
SELECT
INSERT
UPDATE
DELETE
TRUNCATE
REFERENCES
TRIGGER
CREATE
CONNECT
TEMPORARY
EXECUTE
USAGE
SET
ALTER SYSTEM
MAINTAIN
```

https://www.postgresql.org/docs/17/sql-createuser.html

```
CREATE USER name PASSWORD 'password'
```

https://www.postgresql.org/docs/17/sql-lock.html

Autometicky LOCK - nejméně restriktivní

Row-level

LOCK TABLE name IN ROW SHARE MODE NOWAIT

Meaningful only in transactions
Table-level LOCKS .. do konce transakce

LOCK TABLE name IN SHARE MODE NOWAIT

deadlock: locks on the same object always in the same order
for multiple lock modes the most restrictive first

```
BEGIN WORK;
LOCK TABLE films IN SHARE MODE;
SELECT id FROM films
    WHERE name = 'Star Wars: Episode I - The Phantom Menace';
-- Do ROLLBACK if record was not returned
INSERT INTO films_user_comments VALUES
    (_id_, 'GREAT! I was waiting for it for so long!');
COMMIT WORK;
```

```
BEGIN WORK;
LOCK TABLE films IN SHARE ROW EXCLUSIVE MODE;
DELETE FROM films_user_comments WHERE id IN
    (SELECT id FROM films WHERE rating < 5);
DELETE FROM films WHERE rating < 5;
COMMIT WORK;
```

Std SQL: set transaction isolation level ... -->
