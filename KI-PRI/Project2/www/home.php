<? require __DIR__ . '/inc/start.php';
usrId() || redirect('login.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="icon" type="image/svg+xml" href="assets/logo.svg" />
  <link rel="stylesheet" href="css/main.css">
  <script src="js/main.js" defer></script>
</head>

<body>
  <header>
    <img src="assets/logo.svg" title="Logo" style="height: 100%;" class="ptr" onclick="location.href='index.php'">
    <a href="logout.php">Logout</a>
    <?= usr() ?>
  </header>

  <main>
    <button id="top" onclick="scrollToId('bottom')">TOP</button>
    <p>00</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>10</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>20</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>30</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>40</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>main</p>
    <p>50</p>

    <button id="bottom" onclick="scrollToId('top')">BOTTOM</button>
  </main>

  <footer>
    &copy; KI/PRI
  </footer>
</body>

</html>
