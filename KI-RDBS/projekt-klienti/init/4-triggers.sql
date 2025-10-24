-- login
create function on_login()
  returns event_trigger security definer
  language plpgsql as $$
declare
  hour integer = extract('hour' from current_time);
begin
  -- forbid early logging in
  --if hour between 0 and 5 then
    --raise exception 'login forbidden: %', hour;
  --end if;

  insert into audit_log (who,what) values (session_user, 'login');
end; $$;

create event trigger on_login on login
  execute function on_login();

-- weather
create function weather_insert_log()
  returns trigger language plpgsql as $$
begin
  insert into audit_log (who,what) values (session_user, 'new weather: ' || new.*);
  return new;
end; $$;

create trigger weather_insert_log after insert on weather
  for each row execute function weather_insert_log();
