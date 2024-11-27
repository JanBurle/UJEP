def lastInsert(conn):
  curs = conn.execute("""
    select id,who,what from audit_log
      where what<>'login'
      order by id desc;
  """)
  rec = curs.fetchone()
  if rec:
    id,who,what = rec
    print('Last insert:', id, who, what)
  else:
    print('No record')

def truncate(conn):
  curs = conn.execute("truncate audit_log")
