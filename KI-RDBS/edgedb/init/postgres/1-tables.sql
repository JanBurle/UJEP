----

create table log (
  id   serial primary key,
  ts   timestamp default current_timestamp,
  who  text,
  what text
);

create procedure log(what text) security definer language sql as
$$
  insert into log (who,what) values (session_user, log.what);
$$;

----
