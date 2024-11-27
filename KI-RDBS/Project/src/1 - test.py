import pg

# psycopg
with pg.connect() as conn:
  try:
    curs = conn.execute('select version();')
    pgVersion = curs.fetchone()
    print('PG>', pgVersion)
  except Exception as error:
    print('** Error **', error)
