-- data model

create table continent (
  id   integer      primary key,
  name varchar(100) not null unique
);

create table country (
  code         char(2)      primary key,
  id_continent integer      references continent(id),
  name         varchar(100) not null unique
);

create table place (
  id           serial       primary key,
  name         varchar(100) not null,
  code_country char(2)      references country(code),
  latitude     decimal(8,5) not null,
  longitude    decimal(8,5) not null,
  elevation    int
);

-- daily weather data
create table weather (
    id       serial primary key,
    id_place int    references place(id),
    date     date   not null,

    temp_lo  decimal(4,1),  -- daily min temp (°C)
    temp_hi  decimal(4,1),  -- daily max temp (°C)
    precip   decimal(6,2),  -- precipitation (mm)

    unique(id_place, date)
);
