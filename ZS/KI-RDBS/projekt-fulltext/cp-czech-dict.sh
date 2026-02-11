# https://github.com/char0n/postgresql-czech-fulltext
docker cp dict/. postgres:/usr/share/postgresql/18/tsearch_data/

# create text search dictionary czech_spell(template=ispell, dictfile=czech, afffile=czech, stopwords=czech);
# create text search configuration czech (copy=english);
# alter text search configuration czech alter mapping for word, asciiword with czech_spell, simple;
