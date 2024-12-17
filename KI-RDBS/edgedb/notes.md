# complexity - simplicity

ORM - Object Relational Mapping

## SQLAlchemy

monitor SQL

## [EdgeDB](https://edgedb.com/)

```bash
edgedb project init
edgedb project info
edgedb instance list

edgedb
> \h
> \q
> select 1 + 1;
```

tree

.
├── dbschema
│   ├── default.esdl
│   └── migrations
└── edgedb.toml

default.esdl - EdgeDB SDL

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

```bash
edgedb migration create
```

.edgeql (DDL)

apply

```bash
edgedb migrate
edgedb list types
```

```bash
edgedb ui
```

schema - [uuid](https://www.postgresql.org/docs/9.1/datatype-uuid.html), [wiki](https://en.wikipedia.org/wiki/Universally_unique_identifier)

```bash
select Movie;

insert Movie;

insert Movie {
  title := "Dune"
};

select Movie{}
select Movie{*}
select Movie{id,title}
select Movie{id,title,actors}
select Movie{id,title,actors:{name}}
```

update

```bash
type Movie {
  required title: str;
  multi actors: Person;
}
```

```bash
update Movie filter .title = "Dune"
set {
  actors := {
    (insert Person { name := "Patrick Stewart" }),
    (insert Person { name := "Max von Sydow" })
  }
};
```

```bash
select Movie {
  title,
  actors: {
    name
  }
};
```

```bash
select Movie {
  title,
  actors: {
    name
  }
};
```

### Python

```bash
pip install edgedb
```

read.py

- async

read.edgeql

```python
select Movie {
  title,
  actors: {
    name
  }
};
```

edgedb-py --target blocking
