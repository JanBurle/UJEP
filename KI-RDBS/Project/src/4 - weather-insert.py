import pg
import log

# # make insert possible
# with pg.connect() as conn:
#   conn.execute("delete from weather where city_id='at'")

# # implicit transaction
# try:
#   with pg.connect() as conn:
#     conn.execute("insert into weather values('at', 2, 3)")
# except Exception as error:
#   print('** Error **', error)

# # with transaction
# try:
#   with pg.connect() as conn:
#     with conn.transaction():
#       conn.execute("insert into weather values('at', 2, 3)")
#       # conn.rollback()
# except Exception as error:
#   print('** Error **', error)

# last non-login log
try:
  with pg.connect() as conn:
    # log.truncate(conn)
    log.lastInsert(conn)
except Exception as error:
  print('** Error **', error)
