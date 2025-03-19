<? require __DIR__ . '/inc/start.php';
usrId() || redirect('login.php');

$title = 'Home';
$menu = [['validator.php', 'Validate']];
require INC . '/html-prolog.php';
?>
<style>
  main {
    align-items: center;
  }
</style>

<button id="top" onclick="scrollToId('bottom')">TOP</button>

<?
for ($i = 1; $i <= 100; $i++) {
  echo '<p>line ' . sprintf("%03d", $i) . '</p>';
}
?>
<button id="bottom" onclick="scrollToId('top')">BOTTOM</button>

<? require INC . '/html-epilog.php';
