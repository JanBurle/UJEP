drop table if exists mormar;
drop table if exists kategorie;

create table kategorie (
    id      integer      not null primary key,
    jméno   varchar(128) not null unique
);

create table mormar (
    startovní_číslo integer      not null primary key,
    závodník        varchar(128) not null,
    kategorie       integer		 references kategorie(id),
    čas             interval	 not null,
    dsq             boolean      not null default false,
    constraint
	  cas_check check ((čas > ' 00:00:00'::interval))
);

create index idx_čas on mormar(čas);

insert into kategorie values
    (0, 'elf'),
    (1, 'člověk'),
    (2, 'trpaslík'),
    (3, 'skřet'),
    (4, 'maia'),
    (5, 'hobit');

insert into mormar values
    ( 3, 'Azog',    3, '03:56:11', false),
    ( 4, 'Gandalf', 4, '01:34:23', false),
    ( 5, 'Saruman', 4, '01:56:00', false),
    ( 6, 'Sauron',  4, '00:02:00', true),
    ( 7, 'Gimli',   2, '2 days 03:14:00', true),
    ( 8, 'Aragorn', 1, '02:42:42', false),
    ( 9, 'Eowyn',   1, '02:45:12', false),
    ( 2, 'Samvěd',  5, '04:12:00', false),
    (10, 'Bilbo',   5, '04:11:59', false);
