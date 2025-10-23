create database db1;
\c db1;

-- case insensitive text
create extension if not exists citext;

drop table if exists weather, place, country, continent;

-- validation functions

create or replace function is_name(val text)
returns boolean as $$ begin
  return val != '' and val !~ '^\s' and val !~ '\s$';
end; $$ language plpgsql;

-- custom domains

-- name, max. length 100 chars
drop domain if exists d_name;
create domain d_name as citext not null check (length(value) <= 100 and is_name(value));

-- temperature
drop domain if exists d_temp;
create domain d_temp as numeric(4,1) check (value between -90 and 90);

-- 8-region, continent-like world model, weather data

create table continent (
  id   integer  check (0 < id),
  name d_name
);

create table country (
  code         char(2)  check (code ~ '^[A-Z]{2}$'),
  id_continent integer  not null,
  name         d_name
);

create table place (
  id           serial,

  code_country char(2),
  name         d_name,

  -- Also domains?
  latitude     numeric(8,5) not null check (latitude  between  -90 and 90),
  longitude    numeric(8,5) not null check (longitude between -180 and 180),
  elevation    int          not null check (-430 <= elevation and elevation <= 8000) -- Dead Sea shore -430m
);

create table weather (
    id       serial,
    id_place int,
    date     date   not null,

    temp_lo  d_temp,
    temp_hi  d_temp,
    precip   decimal(6,2) check (precip is null or 0 <= precip and precip < 5000),

    check (temp_lo is null or temp_hi is null or temp_lo <= temp_hi)
);
