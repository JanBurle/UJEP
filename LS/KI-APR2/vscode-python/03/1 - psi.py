class Pes:
  # třídní datový člen
  krmivo = ['granule', 'maso']

  # konstruktor
  def __init__(self, jmeno: str, majitel: str, zvuk: str):
    # instanční členy
    self.jmeno    = jmeno
    self.majitel  = majitel
    self.zvuk     = zvuk

  # instanční metody mohou použít instanční i třídní datové členy
  # self: odkaz na objekt
  def stekej(self):
    return f'{self.jmeno}, {self.zvuk}: {self.krmivo}!'

  def zmen_zvuk(self, novy: str):
    self.zvuk = novy

  # třídní metody mohou číst a měnit pouze třídní
  # cls: odkaz na třídu
  @classmethod
  def pridej_krmivo(cls, krmivo):
    cls.krmivo.append(krmivo)

  # statické metody nemají přístup k datům
  @staticmethod
  def jak_dela_pes():
    return "haf haf"

azor = Pes('Azor', 'Petr', 'vrrr')
print(azor.stekej())

alik = Pes('Alík', 'Jana', 'ňaf')
print(alik.stekej())

psi = [azor, alik]
for pes in psi:
  print(pes.stekej())

# volání instančních metod: pomocí objektu
azor.zmen_zvuk('vroom')
alik.zmen_zvuk('fzz')
for pes in psi:
  print(pes.stekej())

# volání třídních metod: pomocí objektu nebo pomocí třídy
azor.pridej_krmivo('knedlík')
for pes in psi:
  print(pes.stekej())

alik.pridej_krmivo('zelí')
for pes in psi:
  print(pes.stekej())

Pes.pridej_krmivo('kost')
for pes in psi:
  print(pes.stekej())

# volání statických metod: pomocí objektu nebo třídy
print(azor.jak_dela_pes())
print(alik.jak_dela_pes())
print(Pes.jak_dela_pes())
