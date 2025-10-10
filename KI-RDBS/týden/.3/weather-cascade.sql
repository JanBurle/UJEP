DROP TABLE IF EXISTS weather;
DROP TABLE IF EXISTS city;

CREATE TABLE city (
  id char(2) PRIMARY KEY,
  name varchar(80) UNIQUE NOT NULL
);

CREATE TABLE weather (
  city_id char(2) REFERENCES city(id) ON DELETE CASCADE,
  temp_lo int NOT NULL,
  temp_hi int NOT NULL,
  date date NOT NULL DEFAULT CURRENT_DATE,
  PRIMARY KEY (city_id, date),
  CONSTRAINT check_temp CHECK(temp_lo <= temp_hi)
);

INSERT INTO city (id, name) VALUES ('sf', 'San Francisco');
INSERT INTO city (id, name) VALUES ('ul', 'Ústí nad Labem');
INSERT INTO city (id, name) VALUES ('lo', 'Louny');
INSERT INTO city (id, name) VALUES ('bn', 'Bílina');

INSERT INTO weather VALUES ('sf', 17, 26, '2014-10-03');

INSERT INTO weather
  VALUES ('sf', 19, 29, '2014-10-02'),
         ('ul',  7, 16, '2014-10-02'),
         ('lo', 12, 18, '2014-10-02');

INSERT INTO weather
  VALUES ('ul', 14, 21);

DELETE FROM city WHERE id = 'sf';
