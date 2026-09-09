create function select_cities()
  returns table(id char(2), name text)
  security definer language sql
as $$
  select id, name from city;
$$;

create function select_weather(in_city_id char(2))
  returns table(city_id char(2), temp_lo int, temp_hi int, date date)
  security definer language sql
as $$
  select city_id, temp_lo, temp_hi, date from weather where city_id=in_city_id;
$$;

create procedure insert_weather(
  in_city_id char(2), in_temp_lo int, in_temp_hi int, in_date date default current_date
)
  security definer language sql
as $$
    insert into weather (city_id, temp_lo, temp_hi, date)
    values (in_city_id, in_temp_lo, in_temp_hi, in_date);
$$;

grant execute on function  select_cities() to joe;
grant execute on function  select_weather(char(2)) to joe;
grant execute on procedure insert_weather(char(2), int, int, date) to joe;
