<?
// root element
$xml = new SimpleXMLElement('<?xml-stylesheet type="text/xsl" href="xml/fakulta.xsl"?><fakulty/>');

// database connection
$db = mysqli_connect("database", "admin", "pwd", "univerzita");

// construct a SimpleXML tree
$fakulty = $db->query('select id, nazev, dekan from Fakulta')->fetch_all();

foreach ($fakulty as [$id, $nazev, $idDekan]) {
  $fakulta = $xml->addChild('fakulta');
  if ($idDekan) {
    $query = $db->query("select jmeno, prijmeni, email from Osoba where id=$idDekan")->fetch_all();
    [$jmeno, $prijmeni, $email] = $query[0];

    $dekan = $fakulta->addChild('dekan');
    $dekan->addChild('jmeno', $jmeno);
    $dekan->addChild('prijmeni', $prijmeni);
    $dekan->addChild('email', $email);
  }
}

header('Content-Type: application/xml');
echo $xml->asXML();
