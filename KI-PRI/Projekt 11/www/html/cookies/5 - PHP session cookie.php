<?php session_start();

$varName = 'views';
$_SESSION[$varName] = $views = @$_SESSION[$varName] + 1;
?>
<!DOCTYPE html>
<html>

<head>
</head>

<body>

</body>

</html>
<!DOCTYPE html>
<html>

<head>
</head>

<body>
    Views: <?=$views?>

    <pre><?php print_r($_COOKIE) ?></pre>
    <pre><?php print_r($_SESSION) ?></pre>
    <pre><?= 'ID: ' . session_id() ?></pre>
</body>

</html>
