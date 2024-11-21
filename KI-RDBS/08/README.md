# 08 – Uživatelé, procedury, triggery

[Pracovní tabulky](./weather.sql)

## Skupiny, uživatelé, role

_Dřívější CREATE GROUP, CREATE USER – dnes stejné jako CREATE ROLE._
_Jiné DBS: USER se přihlašuje. PostgreSQL: v zásadě není rozdíl._

Superuser `dbuser` definovaný v [docker skriptu](./Docker/docker-compose.yml).

Obyčejný uživatel:

```sql
select current_user;
create user joe password 'joepwd';
```

Otevřeme databázové spojení pro `joe` a pak:

```sql
-- joe
select current_user;
select * from city;  -- doh
delete from weather; -- that's safety
update weather set temp_hi=30 where date='2024-11-09';
```

Jako superuser dáme nebo odebereme `joe` oprávnění:

```sql
-- dbuser
grant select on city to joe;
grant select,update on weather to joe;
revoke select on city from joe;
revoke all on city, weather from joe;
```

Nebo vytvoříme roli (skupinu) s oprávněními, a `joe` dostane oprávnění skupiny:

```sql
create role reader;
grant select on city to reader;

grant reader to joe;
revoke reader from joe;
```

## Triggery

Jsou funkce psané v PL/pgSQL, PL/Tcl, PL/Perl, PL/Python, připojené k tabulkám nebo pohledům, automaticky prováděné za určité situace.

Na tabulkách:

- před, po nebo místo INSERT, UPDATE, DELETE (before, after, instead of)
- jednou pro každou řádku nebo jednou pro celý příkaz (per-row, per-statement)
- UPDATE trigger při změně určitého sloupce
- při TRUNCATE

Interakce může být složitá, je nutno vzít v úvahu pořadí operací, a viditelnost změn (rozdíly podle VOLATILE, STABLE, IMMUTABLE funkce).

Na pohledech:

- místo (instead of) INSERT, UPDATE, DELETE

Při změnách v databázi:

- login
- tabulky: ALTER, CREATE, DROP, ...

## Psaní triggerů

Funkce bez parametrů, vstup je implicitní: `new.*`, `old.*` (pomocí struktury TriggerData), vrací typ _trigger_.

```sql
create table audit_log (
  id serial primary key,
  ts timestamp default current_timestamp,
  tx text
);

create or replace function init_session()
  returns event_trigger security definer
  language plpgsql as $$
declare
  hour integer = extract('hour' from current_time);
begin
  -- forbid early logging in
  if hour between 0 and 5 then
    raise exception 'login forbidden: %', hour;
  end if;

  insert into audit_log (tx) values ('login: ' || session_user);
end; $$;

create event trigger init_session on login
  execute function init_session();

select * from audit_log;
```

(Login joe)

```sql
create or replace function weather_insert_log()
  returns trigger language plpgsql as $$
begin
  insert into audit_log (tx) values
  ('new weather: ' || new.*);
  return new;
end; $$;

create trigger weather_insert_log
  before insert on weather
for each row execute function weather_insert_log();

delete from weather where city_id='at';
select * from weather where city_id='at';
select * from audit_log;

insert into weather values('at', 2, 3);
```
