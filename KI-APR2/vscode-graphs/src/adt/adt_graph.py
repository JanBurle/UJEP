# Abstract Data Type (ADT) for a directed weighted graph
# Graphs are collections of vertices and edges
# A vertex is a node in the graph
# An edge is a connection between two vertices

from typing import TypeAlias, List, Tuple

# abstract base class (ADT)
from abc import ABC, abstractmethod

# enums
from enum import Enum

# vertex label
Label: TypeAlias = str

# edge weight
Weight: TypeAlias = float

# return code (success or failure)
class RetCode(Enum):
  FAIL = 0 # failure
  OK   = 1 # success, added
  PASS = 2 # pass, already existed

class AbstractGraph(ABC):
  _inf = float('inf')

  @abstractmethod
  def clear(self):
    '''
    Clears the graph, resetting it to an empty state.
    '''
    pass

  @abstractmethod
  def addNode(self, lbl: Label) -> RetCode:
    '''
    Adds a new node to the graph with the specified label.
    '''
    pass

  @abstractmethod
  def addEdge(self, src: Label, dst: Label, wgt: Weight = 1.0) -> RetCode:
    '''
    Adds a directed weighted edge between two nodes in the graph.
    Creates the nodes if they do not exist.
    '''
    pass

  @abstractmethod
  def hasNode(self, lbl: Label) -> bool:
    '''
    Checks if there is a node with the given label in the graph.
    '''
    pass

  @abstractmethod
  def hasEdge(self, src: Label, dst: Label) -> bool:
    '''
    Checks if there is an edge from the specified source node to the destination node.
    '''
    pass

  @abstractmethod
  def nodes(self) -> List[Label]:
    '''
    Return the list of nodes in the graph.
    '''
    pass

  @abstractmethod
  def edgeWgt(self, src: Label, dst: Label) -> Weight:
    '''
    Return the weight of the edge between the given source and destination nodes.
    If the edge does not exist, return infinity.
    '''
    pass

  @abstractmethod
  def edges(self, src: Label) -> List[Tuple[Label,Weight]]:
    '''
    Return all edges from the given source node: destination node label and edge weight.
    '''
    pass

  def print(self):
    '''
    Prints itself in a human-readable format.
    '''
    for src in self.nodes():
      print(src, end='')
      for dst,wgt in self.edges(src):
        print(f' > {dst}/{wgt}', end='')
      print()

  def adjMx(self) -> List[List[Weight]]:
    '''
    Returns the adjacency matrix of the graph.
    '''
    nodes = self.nodes()
    return [
      [self.edgeWgt(src,dst) for dst in nodes]
        for src in nodes
    ]

  def printMx(self):
    '''
    Pretty-prints the adjacency matrix of the graph.
    '''
    mx = self.adjMx()
    for row in mx:
      print(' '.join([ '•' if wgt!=self._inf else '⋅' for wgt in row]))
    print()
