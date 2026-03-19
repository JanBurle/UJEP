<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
  <link rel="icon" type="image/svg+xml" href="assets/logo.svg" />
  <link rel="stylesheet" href="css/main.css">
  <script src="js/main.js" defer></script>
</head>

<body>

  <header>
    <img src="assets/logo.svg" title="Logo" style="height: 100%;" class="ptr" onclick="location.href='index.php'">
    <?= usrId() ? usr() : $title ?>
    <span style='flex:1'></span>
    <? if (usrId()) {
      // ensures that $menu is defined, and adds the Logout item
      $menu[] = ['logout.php', 'Logout'];
      // an array of links
      $menu = array_map(fn($m) => "<a href='$m[0]'>$m[1]</a>", $menu);
      // seperated by |
      echo implode('|', $menu);
    } ?>

  </header>
  <main>
