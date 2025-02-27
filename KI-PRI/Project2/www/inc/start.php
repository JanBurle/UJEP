<? session_start(); // start the session

// redirect to a page
function redirect(string $url) {
  header("Location: $url");
  die;
}

// set a session variable
function sesSet(string $key, $val) {
  $_SESSION[$key] = trim($val);
}

// get a session variable
function sesGet(string $key, $def = '') {
  return $_SESSION[$key] ?? $def;
}

// get a post value
function postGet(string $key, $def = '') {
  return $_POST[$key] ?? $def;
}

// user login
function login(int $id, string $name, string $email) {
  sesSet('id', $id);
  sesSet('name', $name);
  sesSet('email', $email);
}

// user logout
function logout() {
  session_destroy();
  session_start();
}

function usrId(): int {
  return (int) sesGet('id');
}

function usrName(): string {
  return sesGet('name');
}

function usrEmail(): string {
  return sesGet('email');
}

function usr(): string {
  return usrName() ?: usrEmail();
}
