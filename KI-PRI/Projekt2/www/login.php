<?
require __DIR__ . '/inc/start.php';
require __DIR__ . '/inc/db.php';

$msg   = '';

if (($email = postGet('email')) && ($pwd = postGet('pwd')))
  if (true === ($msg = dbLogin($email, $pwd)))
    redirect('home.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="icon" type="image/svg+xml" href="assets/logo.svg" />
  <link rel="stylesheet" href="css/main.css">
  <style>
    main {
      /* center content */
      justify-content: center;
      align-items: center;
    }

    form {
      border: thin solid var(--pri-bd);
      padding: var(--p4);

      td {
        padding: var(--p1);
      }

      input {
        border: thin solid var(--pri-bd);
        padding: var(--p1);
      }

      button {
        border: thin solid var(--pri-bd);
        font-size: .8em;
        padding: var(--p1) var(--p2);
      }

      td#msg {
        color: var(--pri-hl);
        font-size: .8em;
      }
  </style>
</head>

<body>
  <header>
    <img src="assets/logo.svg" title="Logo" style="height: 100%;" class="ptr" onclick="location.href='index.php'">
    Login
  </header>

  <main>
    <form id="loginForm" method="post">
      <table>
        <tr>
          <td>Email:</td>
          <td><input type="email" name="email" required></td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><input type="password" name="pwd" required></td>
        </tr>
        <tr>
          <td></td>
          <td><button type="submit">Login</button></td>
        </tr>
        <tr>
          <td></td>
          <td id="msg"><?= $msg ?: '&nbsp;' ?></td>
        </tr>
      </table>
    </form>
  </main>

  <footer>
    &copy; UJEP KI/PRI
  </footer>
</body>

</html>
