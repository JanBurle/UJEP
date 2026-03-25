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
        $menuMap = array_map(fn($href, $item) => '<a href="' . h($href) . '"' . ($item[1] ? " class='active'" : "") . '>' . htmlspecialchars($item[0], ENT_QUOTES) . '</a>', array_keys($menu), $menu);
        // // or:
        // $menuMap = [];
        // foreach ($menu as $href => $item) {
        //   $href = h($href);
        //   $activeClass = $item[1] ? " class='active'" : "";
        //   $text = h($item[0]);
        //   $menuMap[] = "<a href='$href$activeClass'>$text</a>";
        // }

        echo implode('|', $menuMap);
      }
    } ?>

  </header>
  <main>
