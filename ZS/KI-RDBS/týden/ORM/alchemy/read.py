from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from mydb import *

engine = create_engine(DB_URL, echo=True)

# database connection
Session = sessionmaker(bind=engine)

with Session() as session:
  # for city in session.query(City.id,City.name).all():
  #   print(city)
  #   print(f"City: {city.name}")

  # for city in session.query(City).filter_by(id='at').all():
  #   print(city)
  #   print(city.__dict__)
  #   print(f"City: {city.name}")
  #   for weather in city.weather: # !!!
  #     print(weather)
  #     print(f"  Weather: {weather.date}, Low: {weather.temp_lo}, High: {weather.temp_hi}")

  for city in session.query(City).all():
    print(f"City: {city.name}")
    for weather in city.weather: # !!!
      print(f"  Weather: {weather.date}, Low: {weather.temp_lo}, High: {weather.temp_hi}")

