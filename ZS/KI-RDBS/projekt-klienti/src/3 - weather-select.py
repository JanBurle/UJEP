import pg

# try:
#   with pg.connect() as conn:
#   # with pg.connect('joe', 'joepwd') as conn:
#     cityId = 'aa'
#     curs = conn.execute('select * from weather where city_id=%s', (cityId,))
#     for rec in curs:
#       print(rec)
# except Exception as error:
#   print('** Error **', error)

try:
  with pg.connect('joe', 'joepwd') as conn:
    curs = conn.execute('select select_weather(%s)', ('at',))
    for rec in curs:
      print(rec)
except Exception as error:
  print('** Error **', error)
