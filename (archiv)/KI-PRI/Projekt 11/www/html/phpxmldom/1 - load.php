<!DOCTYPE html>
<html>

<head>
</head>

<body>
<pre>

<?php
$xmlDoc = new DOMDocument();
$xmlDoc->load('../../xml/knihy.xml');

echo htmlspecialchars($xmlDoc->saveXML());
?>

</pre>
</body>

</html>