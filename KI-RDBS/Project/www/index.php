<!DOCTYPE html>
<html lang="en">

<?php $title = 'Weather App' ?>

<head>
  <title><?= $title ?></title>
  <link rel="stylesheet" href="style.css">
</head>

<?php
// database connection
$conn = new PDO('pgsql:host=postgres;dbname=app', 'joe', 'joepwd');
// qoutes string for html output
$q = fn($s) => htmlspecialchars($s, ENT_QUOTES);
// selected city
$idCity = @$_POST['city'] ?? '';
?>

<body>
  <h1><?= $title ?></h1>

  <form method="post">
    <label for="city">City:</label>
    <select name="city" id="city" onchange="this.form.submit()">
      <?php
      $qry = $conn->query('select id,name from select_cities()');
      while ([$id, $name] = $qry->fetch()) {
        $idCity || $idCity = $id; // if not known, default to first city
        $selected = $id == $idCity ? ' selected' : '';
        echo "<option value='{$q($id)}'$selected>{$q($name)}</option>";
      } ?>
    </select>
  </form>

  <?php
  if ($idCity) {
    // prepared statement, prevents sql injection
    $stmt = $conn->prepare('select date,temp_lo,temp_hi from select_weather(:id)');
    $stmt->execute(['id' => $idCity]);
  ?>
    <h2>Weather Data</h2>
    <table>
      <tr>
        <th>Date</th>
        <th>Low (°C)</th>
        <th>High (°C)</th>
      </tr>
      <?php while ([$date, $low, $high] = $stmt->fetch()) { ?>
        <tr>
          <td><?= $q($date) ?></td>
          <td><?= $q($low) ?></td>
          <td><?= $q($high) ?></td>
        </tr>
      <?php } ?>
    </table>
  <?php } ?>

</body>

</html>
