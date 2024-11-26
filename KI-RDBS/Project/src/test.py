import psycopg2

def connect():
  # https://www.psycopg.org/docs/module.html#psycopg2.connect
  return psycopg2.connect(
    'host=postgres dbname=app user=app-user password=app-pwd'
  )
#   return psycopg2.connect(
#     host = 'postgres',  dbname = 'app',
#     user = 'app-user',  password = 'app-pwd'
#   )

with connect() as conn:
  with conn.cursor() as curs:
    curs.execute("SELECTt version();")
    dbVersion = curs.fetchone()
    print('Connected to', dbVersion)

# try:
#   conn = connect()
#   curs = conn.cursor()

#   curs.execute("SELECTt version();")

#   dbVersion = curs.fetchone()
#   print('Connected to', dbVersion)

# except Exception as error:
#   print('** Error **', error)

# finally:
#   print('Cleanup:', curs!=None, conn!=None)
#   if curs: curs.close()
#   if conn: conn.close()
