DROP TABLE IF EXISTS city;

CREATE TABLE city (
  id char(2) PRIMARY KEY,
  name varchar(80) NOT NULL
);

CREATE UNIQUE INDEX idx_city_name on city(name);

DROP TABLE IF EXISTS city;

CREATE TABLE city (
   id char(2) PRIMARY KEY,
  name varchar(80) UNIQUE NOT NULL
);

INSERT INTO city (id, name) VALUES ('sf', 'San Francisco');
-- INSERT INTO city (id, name) VALUES ('sf', 'San Francisco');   -- chyba
-- INSERT INTO city (id) VALUES ('ul');                          -- chyba
-- INSERT INTO city (name) VALUES ('Ústí nad Labem');            -- chyba
-- INSERT INTO city (id, name) VALUES ('ull', 'Ústí nad Labem'); -- chyba
INSERT INTO city (id, name) VALUES ('ul', 'Ústí nad Labem');
INSERT INTO city (id, name) VALUES ('lo', 'Louny');
INSERT INTO city (id, name) VALUES ('bn', 'Bílina');
-- INSERT INTO city (id, name) VALUES ('bi', 'Bílina');          -- chyba

CREATE TABLE weather (
  city_id char(2) REFERENCES city(id),
  temp_lo int NOT NULL,
  temp_hi int NOT NULL,
  date date NOT NULL DEFAULT CURRENT_DATE,
  CONSTRAINT check_temp CHECK(temp_lo <= temp_hi),
  UNIQUE (city_id, date)
);

INSERT INTO weather
  VALUES ('sf', 19, 29, '2014-10-02'),
         ('ul',  7, 16, '2014-10-02'),
--       ('sf', 26, 17, '2014-10-03'), -- chyba
--       ('dr',  8, 12, '2014-10-02'), -- chyba 'Dresden'
         ('lo', 12, 18, '2014-10-02');

INSERT INTO weather VALUES ('ul',  14, 21);
-- INSERT INTO weather VALUES ('ul',  14, 21); -- chyba
