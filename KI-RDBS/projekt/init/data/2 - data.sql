-- test data

insert into continent (id, name) values
  (1, 'Africa'),
  (2, 'Antarctica'),
  (3, 'Arctic'),
  (4, 'Asia'),
  (5, 'Europe'),
  (6, 'North America'),
  (7, 'South America'),
  (8, 'Oceania');

-- insert all two-letter uppercase codes (AA..ZZ) with generated names
-- assign continents in round-robin fashion

do $$
declare
  code char(2); c1 int; c2 int;
  continent_id int;
  name text;
  n int := 0;
begin
  for c1 in ascii('A')..ascii('Z') loop
    for c2 in ascii('A')..ascii('Z') loop
      code := chr(c1) || chr(c2);
      continent_id := (n % 8) + 1; n := n + 1;
      name := 'Country ' || code;

      insert into country (code, id_continent, name)
        values (code, continent_id, name);
    end loop;
  end loop;
end $$;

-- insert some places for each country (~ 16k rows)

do $$
declare
  row record;
  lati numeric(8,5);
  long numeric(8,5);
  elev int;
  name text;
begin
  for row in select code from country loop
    for i in 1..48 loop
      name := format('Place %s-%02s', row.code, i);
      lati := random() * 180 - 90;    -- [-90, 90)
      long := random() * 360 - 180;   -- [-180, 180)
      elev := -430 + (random() * 8430)::int; -- [-430, 8000]

      insert into place (code_country, name, latitude, longitude, elevation)
        values (row.code, name, lati, long, elev);
    end loop;
  end loop;
end $$;

-- insert some weather data for each place (~ a million rows)

with dates as (
  select
    (date_trunc('month', current_date))::date as start_date,
    (date_trunc('month', current_date) + interval '1 month - 1 day')::date as end_date
), days as (
  select
    generate_series(d.start_date, d.end_date, interval '1 day')::date as dt
  from dates d
)
insert into weather (id_place, date, temp_lo, temp_hi, precip)
select
  p.id, d.dt as date, random() * 30 as tl, 30 + random() * 5, random() * 10
from place p cross join days d;

-- show counts of inserted rows
do $$
declare
  cnt int;
begin
  select count(*) into cnt from continent;
  raise notice 'Inserted % continents', cnt;

  select count(*) into cnt from country;
  raise notice 'Inserted % countries', cnt;

  select count(*) into cnt from place;
  raise notice 'Inserted % places', cnt;

  select count(*) into cnt from weather;
  raise notice 'Inserted % weather reports', cnt;
end $$;
