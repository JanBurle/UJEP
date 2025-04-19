# See: https://github.com/pavelberanek91/UJEP/blob/main/APR2/8_vyhledavani_grafy.ipynb

from typing import TypeAlias, List
from src.graph import Graph

Maze: TypeAlias = List[str]

def createMaze(maze: Maze) -> Graph:
  assert 0 < len(maze),    "nust not be empty"
  assert 0 < len(maze[0]), "must not be empty"
  assert all(len(row) == len(maze[0]) for row in maze), "must be rectangular"

  g = Graph()

  numRows = len(maze)
  numCols = len(maze[0])

  def nodeId(i:int, j:int):
     return f'{i:02}{j:02}'

  def node(i:int, j:int):
     g.addNode(nodeId(i,j))

  def edge(i1:int, j1:int, i2:int, j2:int):
     g.addEdge(nodeId(i1,j1), nodeId(i2,j2))

  for i in range(numRows):
    for j in range(numCols):
      if maze[i][j].isspace():
        node(i,j)
        if 0 < i and maze[i-1][j].isspace():
          edge(i, j, i-1, j)
        if 0 < j and maze[i][j-1].isspace():
          edge(i, j, i, j-1)
        if i < numRows-1 and maze[i+1][j].isspace():
          edge(i, j, i+1, j)
        if j < numCols-1 and maze[i][j+1].isspace():
          edge(i, j, i, j+1)

  return g

maze = [
'  **',
'*  *',
'*   ',
]

g = createMaze(maze)
print(g.nodes())
g.printMx()

def bludiste_A():
    return [[0,1,0,0,0,1,0],
            [0,1,0,1,0,1,0],
            [0,1,0,1,0,0,0],
            [0,1,0,1,0,1,0],
            [0,1,0,1,0,1,0],
            [0,0,0,1,0,1,0]]

def bludiste_B():
    return [[0,0,0,0,0,0,0],
            [1,1,1,1,1,1,0],
            [0,0,0,0,0,1,0],
            [0,0,0,0,0,1,0],
            [0,0,0,0,0,1,0],
            [0,0,0,0,0,1,0]]

def bludiste_C():
    return [[0,0,0,0,0,0,0],
            [0,1,0,0,1,1,0],
            [0,0,1,1,0,1,0],
            [0,0,1,1,0,0,0],
            [0,0,0,1,0,1,1],
            [0,0,0,1,0,0,0]]
