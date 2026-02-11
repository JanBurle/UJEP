from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from mydb import *

engine = create_engine(DB_URL, echo=True)

# create tables
Base.metadata.create_all(engine)

# database connection
Session = sessionmaker(bind=engine)

with Session() as session:
  import random
  from datetime import date, timedelta

  for id1 in range(ord('a'), ord('d') + 1):
    for id2 in range(ord('a'), ord('d') + 1):
      city_id = chr(id1) + chr(id2)
      city_name = 'City ' + city_id.upper()
      city = City(id=city_id, name=city_name)
      session.add(city) # !!!

      for days in range(7):
        temp_lo = random.randint(0, 30)
        temp_hi = temp_lo + random.randint(0, 10)
        weather_date = date.today() - timedelta(days=days)
        weather = Weather(city_id=city_id, temp_lo=temp_lo, temp_hi=temp_hi, date=weather_date)
        session.add(weather) # !!!

  session.commit() # !!!
