<?php session_start();
$page = @$_SESSION['page'] ?: 0;
$page += (int)(@$_POST['n'] ?: '+1');
$page = max(1,min($page,4));
$_SESSION['page'] = $page;

$title = "Stránka $page";
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />

    <script src="https://cdn.tailwindcss.com"></script>

    <title><?= $title ?></title>

    <script>
        function zpět(n) {
            document.forms[0][0].value = '-1'
        }

        function vpřed(n) {
            document.forms[0][0].value = '+1'
        }
    </script>
</head>

<body class="p-4">
    <main class="flex flex-col items-center">
        <form name='navi' method="POST">
        <?php $btnClass = 'class="bg-blue-500 text-white font-bold rounded py-2 px-4"'?>
        <input type="hidden" name="n" value="">
        <input <?=$btnClass?> type="submit" onclick="zpět()" value="Zpět" />
        <input <?=$btnClass?> type="submit" onclick="vpřed()" value="Vpřed" />
        </form>

        <article class="p-4">
        <?php
            define('PAGE_INCLUDE', 1);
            require("page$page.php");
        ?>
        </article>
    </main>
</body>

</html>