import edgedb
import os

fileDir = os.path.dirname(os.path.realpath(__file__))
os.chdir(fileDir)

with edgedb.create_client() as client: # create_async_client()
  movies = client.query("""
    select Movie {
      title,
      actors: {
        name
      }
    }""")

  print(movies)

  dune = client.query("""
    select Movie {
      title,
      actors: {
        name
      }
    }
    filter .title = <str>$name""", name="Dune")

  print(dune)
  print(dune[0].title) if dune else print("No Dune found")
