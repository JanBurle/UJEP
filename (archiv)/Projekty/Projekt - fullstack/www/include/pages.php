<?php
// seznam stránek (href => title)
$pages = [
    '/' => 'Home',
    '/login.php' => 'Přihlášení',
    '/drinks.php' => 'Receptář',
];

// přihlášený uživatel smí nahrávat recepty
if (isUser())
    $pages['/upload.php'] = 'Nahrát';
