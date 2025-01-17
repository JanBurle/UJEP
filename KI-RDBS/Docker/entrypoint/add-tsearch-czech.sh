#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username dbuser postgres <<-EOSQL
  create text search dictionary czech_spell
    (template=ispell, dictfile=czech, afffile=czech, stopwords=czech);
  create text search configuration czech (copy=english);
  alter text search configuration czech
    alter mapping for word, asciiword with czech_spell, simple;
EOSQL
