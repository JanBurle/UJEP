complexity - simplicity

$ edgedb project init
$ edgedb project info
$ edgedb instance list

$ edgedb

select 1 + 1;

\h
\q

./egg
├── edgedb.toml
├── dbschema
│ ├── default.esdl
│ ├── migrations

default.esdl
EdgeDB SDL .esdl

```esdl
module default {
  type Person {
    required name: str;
  }

  type Movie {
    title: str;
    multi actors: Person;
  }
};
```

automatic implicit id UUID (show what is it)
links - foreign keys, joins

$ edgedb migration create
.edgeql (DDL)

apply
$ edgedb migrate

$ edgedb list types

```
  type Movie {
    required title: str;
    multi actors: Person;
  }
```

edgedb ui

```
insert Movie {
  title := "Dune"
};

insert Movie {
};

insert Movie {
};

insert Movie {
  title := "Dune"
};


insert Movie {
};

select Movie {};

select Movie {
  title
};

select Movie {
  title,
  actors: {
    name
  }
};

```

```
require title: str;
required title: str;
```

$ edgedb migration create
$ edgedb migrate

$ edgedb ui
