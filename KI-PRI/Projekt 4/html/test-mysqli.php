<?php
$conn = mysqli_connect("database", "admin", "heslo", "univerzita");
$tables = $conn->query('SHOW TABLES')->fetch_all();
print_r($tables);