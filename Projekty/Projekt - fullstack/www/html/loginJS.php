<?php require __DIR__ . '/../vars.php';
prolog();

require "$INC/db.php";
switch (@$_POST['akce']) {
    case 'login':
        [$id, $jmeno] = dbLogin(@$_POST['jmeno'], @$_POST['heslo']);
        $_SESSION['jmeno'] = $jmeno;
        break;
    case 'logout':
        [$id, $jmeno] = [0, ''];
        unset($_SESSION['jmeno']);
        break;
}

?>

<div class="flex justify-center m-12">
    <form name="loginForm" class="bg-zinc-50 rounded px-8 pt-6 pb-8 mb-4" method="POST" onsubmit="(e)=>alert(e)">
        <?php if ($jmeno) { ?>
            <!-- odhlásit -->
            <input type="hidden" name="akce" value="logout">
            <input class="bg-blue-500 text-white font-bold rounded py-2 px-4" type="submit" value="Odhlásit" />
        <?php } else { ?>
            <!-- přihlásit -->
            <input type="hidden" name="akce" value="login">
            <div class="mb-4">
                Přihlášení
            </div>
            <div class="mb-4">
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="jmeno" type="text" placeholder="jméno" required>
            </div>
            <div class="mb-4">
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    name="heslo" type="password" placeholder="heslo" required>
            </div>
            <input class="bg-blue-500 text-white font-bold rounded py-2 px-4" type="submit" value="Přihlásit" />
        <?php } ?>
    </form>
</div>

<script src="assets/loginValidate.js"></script>

<?php epilog();