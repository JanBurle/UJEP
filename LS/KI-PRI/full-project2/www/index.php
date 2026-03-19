<? require __DIR__ . '/inc/start.php';

redirect(usrId() ? 'home.php' : 'login.php');
