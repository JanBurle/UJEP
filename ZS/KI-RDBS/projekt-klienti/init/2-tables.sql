-- log
create table audit_log (
  id   serial primary key,
  ts   timestamp default current_timestamp,
  who  text,
  what text
);

-- cities/weather data
create table city (
  id    char(2)     primary key,
  name  varchar(80) not null
);

create table weather (
  city_id   char(2) references city(id),
  temp_lo   int     not null,
  temp_hi   int     not null,
  date      date    not null default current_date,

  primary key (city_id, date),
  constraint check_temp check(temp_lo <= temp_hi)
);

create index idx_date on weather(date);

