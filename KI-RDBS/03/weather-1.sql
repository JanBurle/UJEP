DROP TABLE IF EXISTS weather;
DROP TABLE IF EXISTS city;

CREATE TABLE city (
  id char(2),
  name varchar(80) NOT NULL,
  PRIMARY KEY (id)
);

CREATE UNIQUE INDEX idx_city_name on city(name);

CREATE TABLE weather (
  city_id char(2),
  temp_lo int NOT NULL,
  temp_hi int NOT NULL,
  date date NOT NULL DEFAULT CURRENT_DATE,
  PRIMARY KEY (city_id, date),
  CONSTRAINT check_temp CHECK(temp_lo <= temp_hi)
);
