from sqlalchemy import create_engine, String, Integer, Date
from sqlalchemy import Column, ForeignKey, CheckConstraint
from sqlalchemy.orm import declarative_base, sessionmaker, relationship

from datetime import date

# DATABASE_URL = 'sqlite:///example.db'
DATABASE_URL = 'postgresql+psycopg://app-user:app-pwd@localhost:5432/app'
engine = create_engine(DATABASE_URL, echo=False)

Base = declarative_base()

class City(Base):
  __tablename__ = 'acity'
  id       = Column(String(2), primary_key=True)
  name     = Column(String(80), nullable=False)
  aweather = relationship("Weather", back_populates="acity")

class Weather(Base):
  __tablename__ = 'aweather'

  city_id = Column(String(2), ForeignKey('acity.id'), primary_key=True)
  temp_lo = Column(Integer, nullable=False)
  temp_hi = Column(Integer, nullable=False)
  date    = Column(Date, primary_key=True, default=date.today)
  acity   = relationship("City", back_populates="aweather")
  __table_args__ = (
    CheckConstraint('temp_lo <= temp_hi', name='check_temp'),
  )

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
