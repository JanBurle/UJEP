<!DOCTYPE html>
<html lang="cs">

<?php require __DIR__ . '/../../include/predmety.php' ?>

<head>
  <meta charset="UTF-8">
</head>

<body>
  <?php $predmet = @$_REQUEST['predmet'] ?>

  <form method='post'>
    <input type="text" name="predmet" value="<?= $predmet ?>">
    <input type="submit">
  </form>

  <?php if ($predmet) : ?>
    <h2>Tabulka pro <?= $predmet ?></h2>
    <?= tabulkaPredmetu($predmet) ?>
  <?php endif ?>
</body>

</html>
