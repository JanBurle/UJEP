CREATE TABLE cities (
  name varchar(80),
  location point
);

CREATE TABLE weather (
  city varchar(80),
  temp_lo int,  -- low temperature
  temp_hi int,  -- high temperature
  prcp real,    -- precipitation
  date date
);

INSERT INTO cities VALUES ('San Francisco', '(37.78, -122.42)');
INSERT INTO cities VALUES ('Ústí nad Labem',  '(50.66, 14.04)'),
                          ('Louny',           '(50.36, 13.79)'),
                          ('Bílina',          '(50.36, 13.79)');

INSERT INTO weather VALUES ('San Francisco', 19, 29, 0.25, '2014-10-02');
INSERT INTO weather (city, temp_lo, temp_hi, prcp, date)
       VALUES ('Ústí nad Labem', 7, 16, 28, '2014-10-02');

INSERT INTO weather (date, city, temp_hi, temp_lo) VALUES
  ('2014-10-03', 'San Francisco', 17, 26), -- chyba
  ('2014-10-02', 'Louny', 18, 12),
  ('2014-10-02', 'Dresden', 12, 8);

-- SELECT * FROM weather;

-- SELECT city, temp_lo, temp_hi, prcp, date FROM weather;

-- SELECT city, (temp_hi+temp_lo)/2 AS "avg.temp.", date FROM weather;

-- SELECT * FROM weather WHERE city = 'San Francisco' AND prcp > 0.0;

-- SELECT * FROM weather ORDER BY city;

-- SELECT * FROM weather ORDER BY city, temp_lo;

-- SELECT DISTINCT city FROM weather;

-- SELECT ALL city FROM weather;

-- SELECT DISTINCT city FROM weather WHERE city LIKE '%r%' ORDER BY city;

-- UPDATE weather SET temp_lo = -4 WHERE city = 'Louny';

-- UPDATE weather SET temp_hi = 32, temp_lo = temp_hi - 10 WHERE city = 'Louny';

-- DELETE FROM weather WHERE city = 'Hayward';

-- DELETE FROM weather;

-- TRUNCATE weather;
