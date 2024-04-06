<?php
$name = @$_GET['name'];

$file = "/var/mixolog/menu/$name.xml";
// error_log($file);
header("Content-type: text/xml;");
if (file_exists($file))
    readfile($file);