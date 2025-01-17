import pg

with pg.connect() as conn:
  # # fetch all
  # curs = conn.execute('select * from audit_log;')
  # logData = curs.fetchall()
  # print(logData)

  # # iterate
  # curs = conn.execute('select * from audit_log;')
  # for record in curs: # tuples
  #   print(record)

  # # iterate
  # curs = conn.execute('select ts,who,what from audit_log;')
  # for ts,who,what in curs:
  #   print(ts, who, what)

  # # sql injection
  # who = input('who: ')
  # curs = conn.execute(f"select id,who,what from audit_log where who='{who}'")
  # for id,who,what in curs:
  #   print(id, who, what)

  # # proper parametrization
  # who = input('who: ')
  # curs = conn.execute('select id,who,what from audit_log where who=%s', (who,))
  # for id,who,what in curs:
  #   print(id, who, what)
