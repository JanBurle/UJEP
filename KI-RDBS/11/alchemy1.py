from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from alchemydb import *

# DATABASE_URL = 'sqlite:///example.db'
DATABASE_URL = 'postgresql+psycopg://app-user:app-pwd@localhost:5432/app'
engine = create_engine(DATABASE_URL, echo=False)

# create tables
Base.metadata.create_all(engine)

# sample data
Session = sessionmaker(bind=engine)

with Session() as session:
  import random
  from datetime import timedelta

  for id1 in range(ord('a'), ord('z') + 1):
    for id2 in range(ord('a'), ord('z') + 1):
      city_id = chr(id1) + chr(id2)
      city_name = 'City ' + city_id.upper()
      city = City(id=city_id, name=city_name)
      session.add(city)

      for days in range(31):
        temp_lo = random.randint(0, 30)
        temp_hi = temp_lo + random.randint(0, 10)
        weather_date = date.today() - timedelta(days=days)
        weather = Weather(city_id=city_id, temp_lo=temp_lo, temp_hi=temp_hi, date=weather_date)
        session.add(weather)

  session.commit()
