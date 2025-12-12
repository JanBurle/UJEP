import pg
import log

# # empty log
# with pg.connect() as conn:
#    log.truncate(conn)

# make insert possible
with pg.connect() as conn:
  conn.execute("delete from weather where city_id='at'")

# # implicit transaction
# try:
#   with pg.connect() as conn:
#     conn.execute("insert into weather values('at', 2, 3)")
#     # conn.rollback()
#     # conn.commit()
#     # conn.rollback()
# except Exception as error:
#   print('** Error **', error)

# explicit transaction
class PgError(Exception):
  def __init__(self, msg='Error inserting weather data'):
    super().__init__(msg)

from psycopg import Rollback

try:
  with pg.connect() as conn:
    with conn.transaction():
      conn.execute("insert into weather values('at', 2, 3)")
      # raise Rollback()
      # conn.rollback() # not
      # raise PgError()
except PgError:
  print('** Rollback **')
except Rollback:
  print('** Rollback! **')
except Exception as error:
  print('** Error **', error)

# last non-login log
try:
  with pg.connect() as conn:
    log.logTail(conn)
except Exception as error:
  print('** Error **', error)

try:
  with pg.connect('joe', 'joepwd') as conn:
    curs = conn.execute('select select_weather(%s)', ('at',))
    for rec in curs:
      print(rec)
except Exception as error:
  print('** Error **', error)
