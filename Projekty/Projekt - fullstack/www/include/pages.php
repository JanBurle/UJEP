<?php
// URL => title
$pages = [
    '/' => 'Home',
    '/login.php' => 'Přihlášení',
    '/drinks.php' => 'Receptář',
];

if (isLoggedIn())
    $pages['/upload.php'] = 'Nahrát';
