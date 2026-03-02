class Base:
  value   = 'public'
  _value  = 'protected'
  __value = 'private'

  def call(self): # public
    print(1, self.value)
    print(1, self._value)
    print(1, self.__value)

  def _call(self): # protected
    self.call()

  def __call(self): # private
    self.call()

  def m(self):
    self._call()
    self.__call()

class Derived(Base):
  def call(self):
    print(2, self.value)
    print(2, self._value)
    # print(2, self.__value) # error

base = Base()
der = Derived()

base.call()
base._call()
base.m()
# base.__call() # error

der.call()
der._call()
der.m()
# der.__call() # error
