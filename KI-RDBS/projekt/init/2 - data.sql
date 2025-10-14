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

insert into country (code, id_continent, name) values
  ('ZA', 1, 'South Africa'),
  ('EG', 1, 'Egypt'),
  ('KE', 1, 'Kenya'),

  ('AQ', 2, 'Antarctica'),

  ('GL', 3, 'Greenland'),
  ('SJ', 3, 'Svalbard and Jan Mayen'),

  ('CN', 4, 'China'),
  ('IN', 4, 'India'),
  ('JP', 4, 'Japan'),
  ('SA', 4, 'Saudi Arabia'),

  ('DE', 5, 'Germany'),
  ('FR', 5, 'France'),
  ('IT', 5, 'Italy'),
  ('ES', 5, 'Spain'),
  ('CZ', 5, 'Czechia'),
  ('SK', 5, 'Slovakia'),
  ('HU', 5, 'Hungary'),
  ('SI', 5, 'Slovenia'),
  ('RS', 5, 'Serbia'),
  ('ME', 5, 'Montenegro'),
  ('IS', 5, 'Iceland'),
  ('EE', 5, 'Estonia'),
  ('LV', 5, 'Latvia'),
  ('LT', 5, 'Lithuania'),
  ('UA', 5, 'Ukraine'),
  ('BY', 5, 'Belarus'),
  ('PL', 5, 'Poland'),
  ('GB', 5, 'United Kingdom'),
  ('IE', 5, 'Ireland'),
  ('NO', 5, 'Norway'),
  ('SE', 5, 'Sweden'),
  ('FI', 5, 'Finland'),
  ('RU', 5, 'Russia'),

  ('US', 6, 'United States'),
  ('CA', 6, 'Canada'),
  ('MX', 6, 'Mexico'),

  ('BR', 7, 'Brazil'),
  ('AR', 7, 'Argentina'),
  ('CL', 7, 'Chile'),
  ('CO', 7, 'Colombia'),
  ('PE', 7, 'Peru'),

  ('AU', 8, 'Australia'),
  ('NZ', 8, 'New Zealand'),
  ('FJ', 8, 'Fiji'),
  ('PG', 8, 'Papua New Guinea');

insert into place (name, code_country, latitude, longitude, elevation) values
  ('Praha', 'CZ', 50.07554, 14.43780, 235),
  ('Brno', 'CZ', 49.19506, 16.60684, 190),
  ('Ostrava', 'CZ', 49.82092, 18.26252, 214),
  ('Plzeň', 'CZ', 49.73843, 13.37364, 310),
  ('Liberec', 'CZ', 50.76711, 15.05619, 374),
  ('Olomouc', 'CZ', 49.59378, 17.25088, 219),
  ('České Budějovice',  'CZ', 48.97473, 14.47433, 381),
  ('Hradec Králové', 'CZ', 50.20923, 15.83275, 235),
  ('Pardubice', 'CZ', 50.03431, 15.78120, 225),
  ('Ústí nad Labem', 'CZ', 50.66070, 14.03227, 218),
  ('Berlin', 'DE', 52.52000, 13.40500, 34),
  ('Paris', 'FR', 48.85661, 2.35222, 35),
  ('New York', 'US', 40.71278, -74.00597, 10),
  ('Los Angeles', 'US', 34.05223, -118.24368, 71),
  ('Toronto', 'CA', 43.65323, -79.38318, 76),
  ('Mexico City', 'MX', 19.43261, -99.13321, 2250),
  ('Tokyo', 'JP', 35.68949, 139.69171, 40),
  ('Sydney', 'AU', -33.86882, 151.20930, 58),
  ('Sao Paulo', 'BR', -23.55052, -46.63331, 760),
  ('Nairobi', 'KE', -1.29207, 36.82195, 1795),
  ('Cairo', 'EG', 30.04442, 31.23571, 23),
  ('Reykjavik', 'IS', 64.14658, -21.94264, 46),
  ('Cape Town', 'ZA', -33.92487, 18.42406, 25),
  ('Auckland', 'NZ', -36.84846, 174.76333, 79);

-- computed insert
insert into weather (id_place, date, temp_lo, temp_hi, precip)
select p.id, w.dt, w.temp_lo, w.temp_hi, w.precip
from (
  values
    ('Praha', date '2024-01-01', -3.2, 2.5, 0.00),
    ('Praha', date '2024-01-02', -4.0, 1.8, 0.50),
    ('Praha', date '2024-07-15', 16.4, 28.3, 2.20),
    ('London', date '2024-01-01', 3.2, 8.1, 1.80),
    ('London', date '2024-07-15', 14.5, 22.0, 0.40),
    ('New York', date '2024-01-01', -2.3, 4.0, 3.10),
    ('New York', date '2024-07-15', 22.1, 30.5, 5.60),
    ('Tokyo', date '2024-01-01', 2.4, 10.2, 0.00),
    ('Tokyo', date '2024-07-15', 25.0, 31.8, 6.30),
    ('Sydney', date '2024-01-01', 18.2, 26.5, 1.20),
    ('Sydney', date '2024-07-15', 8.8, 17.2, 0.70),
    ('Nairobi', date '2024-01-01', 15.1, 26.8, 0.00),
    ('Reykjavik', date '2024-01-01', -4.6, 1.2, 2.50),
    ('Mexico City', date '2024-07-15', 12.9, 24.7, 8.10),
    ('Cape Town', date '2024-07-15', 8.2, 16.3, 3.70),
    ('Auckland', date '2024-01-01', 16.5, 23.0, 0.90)
) as w(name, dt, temp_lo, temp_hi, precip)
join place p on p.name = w.name;
