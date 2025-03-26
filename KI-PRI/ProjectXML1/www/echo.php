<!DOCTYPE html>
<html>

<body>
  <?
  // header('Content-Type: text/xml'); // NOT possible
  echo file_get_contents('xml/cdcatalog.xml');
  ?>
</body>

</html>
