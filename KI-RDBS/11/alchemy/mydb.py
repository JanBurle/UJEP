from sqlalchemy import Column, ForeignKey, CheckConstraint
from sqlalchemy import String, Integer, Date
from sqlalchemy.orm import declarative_base, relationship

from datetime import date

# The base of all mapped classes
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

DB_URL = 'sqlite:///example.db'
# DB_URL = 'postgresql+psycopg://app-user:app-pwd@localhost:5432/app'
