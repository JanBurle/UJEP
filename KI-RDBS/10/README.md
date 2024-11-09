# 10 – Triggery

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

Funkce bez parametrů, vstup je pomocí struktury TriggerData, vrací typ _trigger_.

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

<!-- CREATE TABLE image (title text, raster lo);
CREATE TRIGGER t_raster BEFORE UPDATE OR DELETE ON image
FOR EACH ROW EXECUTE FUNCTION lo_manage(raster);

///

```
CREATE TABLE emp (
empname text,
salary integer,
last_date timestamp,
last_user text
);
CREATE FUNCTION emp_stamp() RETURNS trigger AS $emp_stamp$
BEGIN
-- Check that empname and salary are given
IF NEW.empname IS NULL THEN
RAISE EXCEPTION 'empname cannot be null';
END IF;
IF NEW.salary IS NULL THEN
RAISE EXCEPTION '% cannot have null salary',
NEW.empname;
END IF;
-- Who works for us when they must pay for it?
IF NEW.salary < 0 THEN
RAISE EXCEPTION '% cannot have a negative salary',
NEW.empname;
END IF;
-- Remember who changed the payroll when
NEW.last_date := current_timestamp;
NEW.last_user := current_user;
RETURN NEW;
END;
$emp_stamp$ LANGUAGE plpgsql;
```

```
CREATE TRIGGER emp_stamp BEFORE INSERT OR UPDATE ON emp FOR EACH ROW EXECUTE FUNCTION emp_stamp();
```

Audit

```
CREATE TABLE emp (
empname text NOT NULL,
salary integer
);
CREATE TABLE emp_audit(
operation char(1) NOT NULL,
stamp timestamp NOT NULL,
userid text NOT NULL,
empname text NOT NULL,
salary integer
);
```

```
CREATE OR REPLACE FUNCTION process_emp_audit() RETURNS TRIGGER AS
$emp_audit$
BEGIN
--
-- Create a row in emp_audit to reflect the operation
performed on emp,
-- making use of the special variable TG_OP to work out the
operation.
--
IF (TG_OP = 'DELETE') THEN
INSERT INTO emp_audit SELECT 'D', now(), current_user,
OLD.*;
ELSIF (TG_OP = 'UPDATE') THEN
INSERT INTO emp_audit SELECT 'U', now(), current_user,
NEW.*;
ELSIF (TG_OP = 'INSERT') THEN
INSERT INTO emp_audit SELECT 'I', now(), current_user,
NEW.*;
END IF;
RETURN NULL; -- result is ignored since this is an AFTER
trigger
END;
$emp_audit$ LANGUAGE plpgsql;

CREATE TRIGGER emp_audit
AFTER INSERT OR UPDATE OR DELETE ON emp
FOR EACH ROW EXECUTE FUNCTION process_emp_audit();
``` -->
<!--
!!!!!!!!!!!!!!!!!!!

````
CREATE TABLE emp (
empname text PRIMARY KEY,
salary integer
);
CREATE TABLE emp_audit(
operation char(1) NOT NULL,
userid text NOT NULL,
empname text NOT NULL,
salary integer,
stamp timestamp NOT NULL
);

CREATE VIEW emp_view AS
SELECT e.empname,
e.salary,
max(ea.stamp) AS last_updated
FROM emp e
LEFT JOIN emp_audit ea ON ea.empname = e.empname
GROUP BY 1, 2;

CREATE OR REPLACE FUNCTION update_emp_view() RETURNS TRIGGER AS $$
BEGIN
--
-- Perform the required operation on emp, and create a row
in emp_audit
-- to reflect the change made to emp.
--
IF (TG_OP = 'DELETE') THEN
DELETE FROM emp WHERE empname = OLD.empname;
IF NOT FOUND THEN RETURN NULL; END IF;
OLD.last_updated = now();
INSERT INTO emp_audit VALUES('D', current_user, OLD.*);
RETURN OLD;
ELSIF (TG_OP = 'UPDATE') THEN
UPDATE emp SET salary = NEW.salary WHERE empname =
OLD.empname;
IF NOT FOUND THEN RETURN NULL; END IF;
NEW.last_updated = now();
INSERT INTO emp_audit VALUES('U', current_user, NEW.*);
RETURN NEW;
ELSIF (TG_OP = 'INSERT') THEN
INSERT INTO emp VALUES(NEW.empname, NEW.salary);
NEW.last_updated = now();
INSERT INTO emp_audit VALUES('I', current_user, NEW.*);
RETURN NEW;
END IF;

END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER emp_audit
INSTEAD OF INSERT OR UPDATE OR DELETE ON emp_view
FOR EACH ROW EXECUTE FUNCTION update_emp_view();
``` -->

```-->

```
