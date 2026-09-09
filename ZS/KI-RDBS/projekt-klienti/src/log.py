def logTail(conn, n=6):
  curs = conn.execute("""
    select id,who,what from audit_log
      where what<>'login'
      order by id desc;
  """)

  for _ in range(n):
    rec = curs.fetchone()
    if not rec:
      break
    id,who,what = rec
    print(id, who, what)

def truncate(conn):
  curs = conn.execute("truncate audit_log")
