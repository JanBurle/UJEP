<?
$menu = [
  'home.php' => ['Home', 0],
  'clock.php' => ['Clock', 0],
  'logout.php' => ['Logout', 0]
];

// bad trick, just to flex
function required_from(): string {
  $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
  return $trace[1]['file'] ?? '';
}

if ($item = &$menu[basename(required_from())]) {
  $item[1] = 1; // mark current page as active
}
