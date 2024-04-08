<?php session_start() ?>
<!DOCTYPE html>
<html lang="cs">
<?php
$INC = __DIR__;
$XML = __DIR__ . '/../xml';
$MENU = '/var/mixolog/menu';

$title = 'Mixolog';
$jmeno = @$_SESSION['jmeno'];
?>

<!-- Tailwind template: https://www.codewithfaraz.com/content/229/how-to-create-a-simple-navbar-with-tailwind-css -->

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>
        <?= $title ?>
    </title>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let button = document.getElementById('navbar-toggle');
            let menu = document.getElementById('navbar-default');

            // function toggleMenu() { menu.classList.toggle('hidden'); }
            let toggleMenu = () => menu.classList.toggle('hidden')

            button.addEventListener('click', toggleMenu)
        });
    </script>
</head>

<body>