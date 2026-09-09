<? require __DIR__ . '/../inc/start.php';
usrId() || redirect('login.php');

$title = 'JS Clock';
require INC . 'menu.php';
require INC . 'html-prolog.php';
?>
<style>
  main {
    /* center content */
    justify-content: center;
    align-items: center;
  }

  .movable {
    cursor: move;
  }
</style>
<script src="js/clock.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => makeClock(140))
</script>

<svg width="300" height="300">
  <g
    id="clock"
    transform="translate(150 150)"
    stroke="black"
    stroke-width="4"
    stroke-linecap="round">
    <circle r="140" fill="white" />
  </g>
</svg>

<div id="time"></div>

<? require INC . 'html-epilog.php';
