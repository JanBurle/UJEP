from persistent import Persistent

class City(Persistent):
  def __init__(self, id, name):
    self.id = id
    self.name = name

  def __repr__(self):
    return f"City(id='{self.id}', name='{self.name}')"

class Weather(Persistent):
  def __init__(self, city_id, temp_lo, temp_hi, date):
    self.city_id = city_id
    self.temp_lo = temp_lo
    self.temp_hi = temp_hi
    self.date = date

  def __repr__(self):
    return f"Weather(city_id='{self.city_id}', temp_lo={self.temp_lo}, temp_hi={self.temp_hi}, date={self.date})"
