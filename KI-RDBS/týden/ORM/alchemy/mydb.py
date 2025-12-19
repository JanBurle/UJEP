from sqlalchemy import Column, ForeignKey, CheckConstraint
from sqlalchemy import String, Integer, Date
from sqlalchemy.orm import declarative_base, relationship

from datetime import date

# The base of all mapped classes
Base = declarative_base()

class City(Base):
  __tablename__ = 'city2'
  id      = Column(String(2), primary_key=True)
  name    = Column(String(80), nullable=False)
  weather = relationship("Weather", back_populates="city")

class Weather(Base):
  __tablename__ = 'weather2'
  city_id = Column(String(2), ForeignKey('city2.id'), primary_key=True)
  temp_lo = Column(Integer, nullable=False)
  temp_hi = Column(Integer, nullable=False)
  date    = Column(Date, primary_key=True, default=date.today)
  city    = relationship("City", back_populates="weather")
  __table_args__ = (
    CheckConstraint('temp_lo <= temp_hi', name='check_temp'),
  )

DB_URL = 'sqlite:///example.db'
# DB_URL = 'postgresql+psycopg://app-user:app-pwd@localhost:5432/app'
