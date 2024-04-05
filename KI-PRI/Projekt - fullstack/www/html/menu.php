<?php require __DIR__ . '/../inc/head.php';

require "$INC/nav.php";
require "$INC/xmlTools.php";

xmlFileList($MENU);
?>

<div class="py-6 text-center">
    <h1 class="mb-6 text-5xl">Drinky</h1>
</div>

<div class="bg-zinc-50 m-6 flex justify-center">
    <ol class="fa-ul">
        <?php foreach (xmlFileList($MENU) as $basename) { ?>
            <li>
                <i class="fa fa-li fa-glass"></i>
                <a class="hover:underline" href="?drink=<?= $basename ?>">
                    <?= $basename ?>
                </a>
            </li>
        <?php } ?>
    </ol>
</div>

<?php if ($drink = @$_GET['drink']) { ?>
    <hr>
    drink
<?php } ?>

<?php require "$INC/foot.php";
