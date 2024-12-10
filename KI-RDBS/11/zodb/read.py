from ZODB import FileStorage, DB
import transaction
from mydb import *

storage = FileStorage.FileStorage('weather.fs')
db = DB(storage)
connection = db.open()
root = connection.root()

try:
  transaction.begin()

  print(root)

  for city in root['city'].values():
    print(city)

  for weather in root['weather'].values():
    print(weather)

  transaction.commit()

finally:
  connection.close()
  db.close()
