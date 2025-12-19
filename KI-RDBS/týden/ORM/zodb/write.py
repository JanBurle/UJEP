from ZODB import FileStorage, DB
import transaction
from mydb import *

storage = FileStorage.FileStorage('weather.fs')
db = DB(storage)
connection = db.open()
root = connection.root()

try:
  transaction.begin()

  for coll in ['city', 'weather']:
    if coll not in root: root[coll]  = {}

  collCity = root['city']
  collCity['mo'] = City('mo', 'Most')
  collCity['bi'] = City('bi', 'Bílina')

  collWeather = root['weather']
  collWeather[('mo', '2023-10-01')] = Weather('mo', 10, 20, '2023-10-01')
  collWeather[('bi', '2023-10-01')] = Weather('bi', 12, 22, '2023-10-01')

  transaction.commit()

finally:
  connection.close()
  db.close()
