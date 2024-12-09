# from sqlalchemy import create_engine, Column, Integer, String, Date, ForeignKey, CheckConstraint
# from sqlalchemy.ext.declarative import declarative_base
# from sqlalchemy.orm import sessionmaker, relationship
# from datetime import date, timedelta
# import random

# Define the database URL for PostgreSQL
DATABASE_URL = 'postgresql+psycopg://app-user:app-pwd@localhost:5432/app'

# Create an engine
engine = create_engine(DATABASE_URL, echo=True)

# Create a session
Session = sessionmaker(bind=engine)
with Session() as session:
  for city in session.query(City).all():
        print(f"City: {city.name}")
        for weather in city.weather:
            print(f"  Weather: {weather.date}, Low: {weather.temp_lo}, High: {weather.temp_hi}")

# Close the session
session.close()
