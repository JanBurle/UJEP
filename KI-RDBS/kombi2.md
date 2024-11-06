Pocasi

```sql
drop table if exists weather;
drop table if exists city;

create table city (
  id char(2) primary key,
  name varchar(80) not null
);

create table weather (
  city_id char(2) references city(id),
  temp_lo int not null,
  temp_hi int not null,
  date date not null default current_date,
  primary key (city_id, date),
  constraint check_temp check(temp_lo <= temp_hi)
);

create index idx_date on weather(date);
```

Naplnit daty

```sql
do $$
declare
  id char(2); id1 integer; id2 integer; name varchar(80);
  temp_lo integer; temp_hi integer; weather_date date; days integer;
begin
  for id1 in ascii('a')..ascii('z') loop
    for id2 in ascii('a')..ascii('z') loop
      id := chr(id1) || chr(id2);
      name := 'City ' || upper(id);
      insert into city (id, name) values (id, name);

      for days in 0 .. 30 loop
        temp_lo := (random() * 30)::int;
        temp_hi := temp_lo + (random() * 10)::int;
        weather_date := current_date - days;
        insert into weather (city_id, temp_lo, temp_hi, date)
          values (id, temp_lo, temp_hi, weather_date);
      end loop;

    end loop;
  end loop;
end $$;
```

Dotazy

```sql
select * from city;
select * from weather;

select city_id, date, temp_hi-temp_lo from weather;
select name, date, temp_hi-temp_lo from weather join city on id=city_id;
select c.name, w.date, w.temp_hi-w.temp_lo from weather w join city c on c.id=w.city_id;
```

Pohledy a dotazy

```sql
create view city_weather as
  select c.name, w.date, w.temp_hi-w.temp_lo from weather w join city c on c.id=w.city_id;

select * from city_weather;

drop view city_weather;
create view city_weather as
  select c.name, w.date, w.temp_hi-w.temp_lo as d_temp from weather w join city c on c.id=w.city_id;

select * from city_weather where d_temp<4 and name like '%Z';
```

Modifikovatelné (updatable) views, za určitých podmínek

```sql
create view city_up_weather as
  select date, temp_lo, temp_hi from weather where city_id='up';
select * from city_up_weather;

update city_up_weather set temp_hi=30 where date='2024-10-08';
```

Indexy 04

Role, User

```sql
create user joe password 'joepwd';
```

new connection

```sql
-- joe
select * from city; -- doh
```

```sql
grant select on city to joe;
grant select,update on city to joe;
revoke select on city from joe;
revoke all on city from joe;
```

```sql
create role reader;
grant reader to joe;
grant select on city to reader;
```

Uložené funkce a procedury
07

Kurzory

```sql
create or replace function count_cities(like_name text = '%')
  returns integer as $$
declare
  city_cursor cursor for select id, name from city;
  city_record record;
  cnt integer;
begin
  cnt = 0;

  open city_cursor;
  loop
    fetch next from city_cursor into city_record;
    exit when not found;
    if city_record.name like like_name then
      cnt = cnt + 1;
    end if;
  end loop;

  close city_cursor;
  return cnt;
end; $$ language plpgsql;

select count_cities();
select count_cities('%');
select count_cities('Ci%Z');
```

Chyby, výjimky:

```sql
select * from weather;

create or replace function avg_temp_lo(like_id text = '%')
  returns real as $$
declare
  weather_cursor cursor for select city_id, temp_lo, temp_hi from weather;
  weather_record record;
  cnt integer;
  sum real;
begin
  cnt = 0; sum = 0;

  open weather_cursor;
  loop
    fetch next from weather_cursor into weather_record;
    exit when not found;

    -- if not (weather_record.temp_lo <= weather_record.temp_hi) then
    --  raise exception 'Invalid temperature data: %', weather_record;
    -- end if;

    if weather_record.city_id like like_id then
      cnt = cnt + 1;
      sum = sum + weather_record.temp_lo;
    end if;
  end loop;

  close weather_cursor;
  return sum / cnt;
-- exception
--  when division_by_zero then
--    return null;
end; $$ language plpgsql;

select avg_temp_lo();
select avg_temp_lo('%');
select avg_temp_lo('%z');
select avg_temp_lo('%Z'); -- error
```

```sql

```

Trigger, Audit

Lock

CTE

ORM

````

```

```
````
