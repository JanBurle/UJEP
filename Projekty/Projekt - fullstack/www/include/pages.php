<?php
// URL => title
$pages = [
    '/' => 'Home',
    '/login.php' => 'Přihlášení',
    '/loginJS.php' => '(JS)',
    '/menu.php' => 'Receptář',
    '/menuXHR.php' => '(XHR)',
    '/menuFetch.php' => '(fetch)',
];

if (isLoggedIn())
    $pages['/upload.php'] = 'Nahrát';
