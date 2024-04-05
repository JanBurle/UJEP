<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
</head>

<body>
    <?php $myName = @$_REQUEST['my-name'] ?>

    <form method='post'>
        <input type="text" name="my-name" value="<?= $myName ?>">
        <input type="submit">
    </form>

    <pre>
        <?php
        echo 'GET:';
        print_r($_GET);
        echo 'POST:';
        print_r($_POST);
        echo 'REQUEST:';
        print_r($_REQUEST);
        echo 'SERVER:';
        print_r($_SERVER);
        ?>
    </pre>

</body>

</html>