<?php require __DIR__ . '/../vars.php';

prolog(['db']);

switch (@$_POST['akce']) {
    case 'login':
        [$id, $jmeno] = dbLogin(@$_POST['jmeno'], @$_POST['heslo']);
        setJmeno($jmeno);
        break;
    case 'logout':
        [$id, $jmeno] = [0, ''];
        setJmeno();
        break;
}

mods(['nav']);

$isIn = isLoggedIn();
$inputCls = "shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline";
?>

<script>
    function onSubmit(e) {
        // no default submit
        e.preventDefault()

        <?php if (!$isIn) { ?>
            // inputs
            let { jmeno, heslo } = this.elements

            // trim and check
            if ((jmeno.value = jmeno.value.trim()).length < 3) {
                alert('Jméno je krátké')
                return
            }

            // trim and check
            if ('heslo' == (heslo.value = heslo.value.trim())) {
                alert('Heslo nesmí být "heslo"')
                return
            }
        <?php } ?>

        // continue to submit
        this.submit()
    }
</script>

<div class="flex justify-center m-12">
    <form name="loginForm" class="bg-zinc-50 rounded px-8 pt-6 pb-8 mb-4" method="POST">
        <input type="hidden" name="akce" value="<?= $isIn ? 'logout' : 'login' ?>">
        <?php if (!$isIn) { ?>
            <div class="mb-4">
                Přihlášení
            </div>
            <div class="mb-4">
                <input class="<?= $inputCls ?>" name="jmeno" type="text" placeholder="jméno" required>
            </div>
            <div class="mb-4">
                <input class="<?= $inputCls ?>" name="heslo" type="password" placeholder="heslo" required>
            </div>
        <?php } ?>
        <input class="bg-blue-500 text-white font-bold rounded py-2 px-4" type="submit"
            value="<?= $isIn ? 'Odhlásit' : 'Přihlásit' ?>" />
    </form>
</div>

<script>
    document.loginForm.addEventListener('submit', onSubmit)
</script>

<?php epilog();