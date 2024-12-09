from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from alchemydb import *

# DATABASE_URL = 'sqlite:///example.db'
DATABASE_URL = 'postgresql+psycopg://app-user:app-pwd@localhost:5432/app'
engine = create_engine(DATABASE_URL, echo=False)

# Create a session
Session = sessionmaker(bind=engine)
with Session() as session:
  for city in session.query(City.id,City.name).all():
    print(f"City: {city.name}")

  for city in session.query(City).filter_by(id='at').all():
    print(f"City: {city.name}")
    for weather in city.aweather:
      print(f"  Weather: {weather.date}, Low: {weather.temp_lo}, High: {weather.temp_hi}")

