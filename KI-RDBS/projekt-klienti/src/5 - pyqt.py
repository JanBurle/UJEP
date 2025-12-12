import pg

# https://www.pythonguis.com/faq/which-python-gui-library/#pyqt-or-pyside
from PySide6.QtWidgets import     \
  QApplication, QWidget,          \
  QHBoxLayout,  QVBoxLayout,      \
  QComboBox,                      \
  QTableWidget, QTableWidgetItem, \
  QPushButton, QLineEdit

# main window
class Win(QWidget):
  # constructor
  def __init__(self):
    super().__init__()
    self.initUI()

  def init(self):
    # permanent database connection
    self.conn = pg.connect('joe', 'joepwd')
    # fetch list of cities
    self.fetchCities()

  # initialize UI
  def initUI(self):
    # main window
    self.setWindowTitle('Weather App')
    self.setGeometry(100, 100, 400, 300)

    # list of cities
    self.cmbCities = QComboBox(self)
    self.cmbCities.currentIndexChanged.connect(self.fetchWeather)

    # weather data for the selected city
    tbl = self.tblWeather = QTableWidget(self)
    tbl.setColumnCount(3)
    tbl.verticalHeader().setVisible(False)
    tbl.horizontalHeader().setStretchLastSection(True)
    tbl.setHorizontalHeaderLabels(['Date', 'Low (°C)', 'High (°C)'])

    # error and other messages
    self.msgLine = QLineEdit(self)
    self.msgLine.setReadOnly(True)

    # action buttons
    buttons = QHBoxLayout()

    # re-read data
    btnFetch = QPushButton('Refresh', self)
    btnFetch.pressed.connect(self.fetchCities)
    buttons.addWidget(btnFetch)

    # quit app
    btnQuit = QPushButton('Quit', self)
    btnQuit.pressed.connect(self.close)
    buttons.addWidget(btnQuit)

    # main layout
    layout = QVBoxLayout()
    layout.addWidget(self.cmbCities)
    layout.addWidget(self.tblWeather)
    layout.addWidget(self.msgLine)
    layout.addLayout(buttons)
    self.setLayout(layout)

  # set message text
  def setMsg(self, msg):
    self.msgLine.setText(msg)

  # set error text
  def setErr(self, msg):
    self.setMsg('Error: ' + msg)

  # clear weather data
  def clearWeatherData(self):
    self.tblWeather.setRowCount(0)

  # display weather data
  def addWeatherData(self, date, low, high):
    rowCnt = self.tblWeather.rowCount()
    self.tblWeather.insertRow(rowCnt)
    for i, elem in enumerate([date, low, high]):
      self.tblWeather.setItem(rowCnt, i, QTableWidgetItem(str(elem)))

  # fetch list of cities
  def fetchCities(self):
    self.setMsg('ready')
    try:
      curs = self.conn.execute('select select_cities()')
      for ((id,name),) in curs:
        self.cmbCities.addItem(name, id)
    except Exception:
      self.setErr('fetch cities')

  # fetch weather data
  def fetchWeather(self):
    # get currently selected city
    cityId = self.cmbCities.currentData()

    self.clearWeatherData()
    try:
      curs = self.conn.execute('select select_weather(%s)', (cityId,))
      for ((_,low,high,date),) in curs:
        self.addWeatherData(date, low, high)
    except Exception:
      self.setErr('fetch weather')

# main
if __name__ == '__main__':
  app = QApplication([])

  win = Win()
  win.show()

  try:
    win.init()
  except Exception as error:
    print(error)
    win.setErr(str(error))

  app.exec()
