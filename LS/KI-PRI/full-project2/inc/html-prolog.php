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
      if (isset($menu)) {
        // menu items, separated by |
        $menuMap = array_map(fn($href, $item) => "<a href='$href'" . ($item[1] ? " class='active'" : "") . ">$item[0]</a>", array_keys($menu), $menu);
        echo implode('|', $menuMap);
      }
    } ?>

  </header>
  <main>
