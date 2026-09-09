<?
$xml = simplexml_load_file('xml/student.xml');

// projít celý strom
function traverse($xml, $level = 0) {
  $space = fn($level) => str_repeat(' ', $level * 2);

  foreach ($xml->attributes() as $name => $value)
    echo $space($level) . "$name - $value\n";

  foreach ($xml->children() as $name => $value) {
    if (0 < $value->count()) {
      echo $space($level) . "$name: \n";
      traverse($value, $level + 1);
    } else {
      echo $space($level) . "$name = $value\n";
    }
  }
}

echo '<pre>';
traverse($xml);
echo '</pre>';
