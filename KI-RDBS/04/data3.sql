DROP TABLE IF EXISTS weather;
DROP TABLE IF EXISTS city;

CREATE TABLE city (
  id char(2) PRIMARY KEY,
  name varchar(80) NOT NULL
);

CREATE TABLE weather (
  city_id char(2) REFERENCES city(id),
  temp_lo int NOT NULL,
  temp_hi int NOT NULL,
  date date NOT NULL DEFAULT CURRENT_DATE,
  CONSTRAINT check_temp CHECK(temp_lo <= temp_hi)
);

CREATE INDEX idx_temp_lo on weather(temp_lo);

DO $$
DECLARE
  id char(2); id1 integer; id2 integer; name varchar(80);
  temp_lo integer; temp_hi integer; weather_date date; days integer;
BEGIN
  FOR id1 IN ascii('a')..ascii('z') LOOP
    FOR id2 IN ascii('a')..ascii('z') LOOP
      id := chr(id1) || chr(id2);
      name := 'City ' || upper(id);
      INSERT INTO city (id, name) VALUES (id, name);

      FOR days in 0 .. 30 LOOP
        temp_lo := (random() * 30)::int;
        temp_hi := temp_lo + (random() * 10)::int;
        weather_date := current_date - days;
        INSERT INTO weather (city_id, temp_lo, temp_hi, date)
          VALUES (id, temp_lo, temp_hi, weather_date);
      END LOOP;

    END LOOP;
  END LOOP;
END $$;
