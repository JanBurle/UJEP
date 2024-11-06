<!-- # 10 – Triggery

Funkce psané v PL/pgSQL, PL/Tcl, PL/Perl, PL/Python

Připojené k tabulkám, pohledům.

Automaticky provedené za určité situace. Na tabulkách:

- před, po nebo místo INSERT, UPDATE, DELETE (before, after, instead of)
- jednou pro každou řádku / jednou pro příkaz (per-row, per-statement)
- UPDATE trigger při změně určitého sloupce
- pro TRUNCATE

Může to být složitá interakce: pořadí, viditelnost změn (VOLATILE, STABLE, IMMUTABLE funkce).

Na pohledech:

- místo (INSTEAD) INSERT, UPDATE, DELETE

Event triggers: login, table rewrite ALTER, CREATE, DROP, ...

Funkce: bez parametrů (vstup je přes TriggerData strukturu), vrací typ _trigger_

```sql
create table audit_log (
id serial primary key,
ts timestamp default current_timestamp,
tx text);

CREATE OR REPLACE FUNCTION init_session()
RETURNS event_trigger SECURITY DEFINER
LANGUAGE plpgsql AS
$$
$$;
```

```sql
CREATE OR REPLACE FUNCTION measurement_insert_trigger()
RETURNS TRIGGER AS $$
BEGIN
INSERT INTO measurement_y2008m01 VALUES (NEW.*);
RETURN NULL;
END;
$$
LANGUAGE plpgsql;

CREATE TRIGGER insert_measurement_trigger
BEFORE INSERT ON measurement
FOR EACH ROW EXECUTE FUNCTION measurement_insert_trigger();
```

CREATE TABLE image (title text, raster lo);
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
```

!!!!!!!!!!!!!!!!!!!

```
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
