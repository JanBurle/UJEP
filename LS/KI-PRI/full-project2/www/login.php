<?
require __DIR__ . '/../inc/start.php';
require INC . 'db.php';

$msg   = '';

if (($email = postGet('email')) && ($pwd = postGet('pwd')))
  if (true === ($msg = dbLogin($email, $pwd)))
    redirect('home.php');

$title = 'Login';
require INC . 'html-prolog.php';
?>
<style>
  main {
    /* center content */
    justify-content: center;
    align-items: center;
  }
</style>

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

<? require INC . 'html-epilog.php';
