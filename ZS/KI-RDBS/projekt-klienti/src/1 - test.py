import pg

# console app
with pg.connect() as conn:
  try:
    # curs = conn.execute('select version();')
    curs = conn.execute('select versionn();')
    pgVersion = curs.fetchone()
    print('PG VERSION: ', pgVersion)
  except Exception as error:
    print('** Error **', error)
