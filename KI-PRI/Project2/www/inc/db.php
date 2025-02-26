<?
function dbLogin(string $email, string $pwd): bool|string {
  $host = 'postgres';
  $user = 'app-user';
  $pass = 'app-pwd';
  $db   = 'app';

  try {
    $pdo = new PDO(/*DSN*/"pgsql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    return 'DB error'; // full message: $e->getMessage();
  }

  $sql = 'select id,name from users where email=:email and pwd_hash=crypt(:pwd,pwd_hash)';
  $sql = $pdo->prepare($sql);
  $sql->bindParam(':email', $email, PDO::PARAM_STR);
  $sql->bindParam(':pwd',   $pwd,   PDO::PARAM_STR);
  $sql->execute();

  $res = $sql->fetchAll(PDO::FETCH_NUM);
  [$id, $name]  = $res[0] ?? [null, null];

  if ($id) {
    login($id, $name, $email);
    return true;
  }

  return 'Invalid login';
}
