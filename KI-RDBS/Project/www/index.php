<!DOCTYPE html>
<html lang="en">

<?php $title = 'Weather App' ?>

<head>
  <title><?= $title ?></title>
  <link rel="stylesheet" href="style.css">
</head>

<?php $conn = new PDO('pgsql:host=postgres;dbname=app', 'joe', 'joepwd') ?>
<?php
$q = fn($s) => htmlspecialchars($s, ENT_QUOTES);
?>

<body>
  <h1><?= $title ?></h1>

  <?php $selCity = @$_POST['city'] ?? '' ?>

  <form method="post">
    <label for="city">City:</label>
    <select name="city" id="city" onchange="this.form.submit()">
      <?php
      $qry = $conn->query('select * from select_cities()');
      while ([$id, $name] = $qry->fetch()) {
        $selCity || $selCity = $id;
        $selected = $id == $selCity ? 'selected' : ''; ?>
        <option value='<?= $q($id) ?>' $selected><?= $q($name) ?></option>
      <?php } ?>
    </select>
  </form>

  <?php
  if ($selCity) {
    $stmt = $conn->prepare('SELECT * FROM select_weather(:city_id)');
    $stmt->execute(['city_id' => $selCity]);
  ?>
    <h2>Weather Data</h2>
    <table>
      <tr>
        <th>Date</th>
        <th>Low (°C)</th>
        <th>High (°C)</th>
      </tr>
      <?php while ([$id, $low, $high, $date] = $stmt->fetch()) { ?>
        <tr>
          <td><?= $q($date) ?></td>
          <td><?= $q($low) ?></td>
          <td><?= $q($high) ?></td>
        </tr>
      <?php } ?>
    </table>
  <?php } ?> ?>

</body>

</html>
