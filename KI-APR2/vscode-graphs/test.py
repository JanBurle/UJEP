if '__main__' == __name__:
  from src.graph import Graph

  g = Graph()
  g.addNode('A')
  g.addNode('B')
  g.addNode('C')
  g.addEdge('D','E',4)
  g.addEdge('D','D',8)

  print(g.adjMx())
  g.printMx()
  # print(g.nodes())
  # g.print()
  # print(g.edgeWgt('A','B'))
  # print(g.edgeWgt('D','D'))

  # g.clear()
  # print(g.nodes())
