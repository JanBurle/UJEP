create extension pgcrypto;

create table users (
    id serial primary key,
    name     text,
    email    text not null unique,
    pwd_hash text not null
);

insert into users (name,email,pwd_hash) values
    ('John Doe',     'john@example.com',  '$2a$06$oUg2YgYf8n5AGE/7lNLQF.D0tDoLMIreyoIKozEnul4/LUVSNOXnO'),
    ('Jane Smith',   'jane@example.com',  '$2a$06$DmP96yFuUGZOc9l2b9AgYu0YtuRYQyl6.a/Tbw2sGzfWpU94Jv71.'),
    ('Alice Johnson','alice@example.com', '$2a$06$wfDs9lkxrg.HJz/889QK..vP0F2MraMcx4zJa0nPyFpeIWJZttobO');
