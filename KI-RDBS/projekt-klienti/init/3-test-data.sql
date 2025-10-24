-- insert test weather data

do $$
declare
  id char(2); id1 integer; id2 integer; name varchar(80);
  temp_lo integer; temp_hi integer; weather_date date; days integer;
begin
  for id1 in ascii('a')..ascii('z') loop
    for id2 in ascii('a')..ascii('z') loop
      id := chr(id1) || chr(id2);
      name := 'City ' || upper(id);
      insert into city (id, name) values (id, name);

      for days in 0 .. 30 loop
        temp_lo := (random() * 30)::int;
        temp_hi := temp_lo + (random() * 10)::int;
        weather_date := current_date - days;
        insert into weather (city_id, temp_lo, temp_hi, date)
          values (id, temp_lo, temp_hi, weather_date);
      end loop;

    end loop;
  end loop;
end $$;
