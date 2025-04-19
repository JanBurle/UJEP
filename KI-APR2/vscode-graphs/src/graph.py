from .adt.adt_graph import AbstractGraph, Label, RetCode, Weight
from typing import List, Tuple
from .lib import diktionphi as δίκτυο

class Graph(AbstractGraph):
  def __init__(self):
    super().__init__()
    self._g = δίκτυο.Graph(δίκτυο.GraphType.DIRECTED)

  def clear(self):
    self._g._nodes.clear()

  def addNode(self, lbl: Label) -> RetCode:
    try:
      self._g.add_node(lbl)
      RetCode.OK
    except:
      return RetCode.PASS

  def addEdge(self, src: Label, dst: Label, wgt: Weight = 1) -> RetCode:
    try:
      self._g.add_edge(src, dst, {'weight': wgt})
      RetCode.OK
    except:
      return RetCode.PASS

  def hasNode(self, lbl: Label) -> bool:
    return lbl in self._g

  def hasEdge(self, src: Label, dst: Label) -> bool:
    try:
      return self._g.node(src).is_edge_to(dst)
    except:
      return False

  def nodes(self) -> List[Label]:
    return list(self._g.node_ids())

  def edgeWgt(self, src: Label, dst: Label) -> Weight:
    try:
      return self._g.node(src).to(dst)['weight']
    except:
      return self._inf

  def edges(self, src: Label) -> List[Tuple[Label,Weight]]:
    try:
      res = []
      srcNode = self._g.node(src)
      for node in srcNode.neighbors_nodes:
        res.append((node.id, srcNode.to(node)['weight']))
      return res
    except:
      return []

