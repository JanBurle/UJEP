def connect(user='app-user',pwd='app-pwd'):
  import psycopg
  import socket

  def host():
    return 'localhost' if 'lc' == socket.gethostname() else 'postgres'

  return psycopg.connect(
    host=host(), dbname='app',
    user=user, password=pwd,
  )
