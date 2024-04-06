<?php require __DIR__ . '/../inc/head.php';

require "$INC/nav.php";
require "$INC/tools.php";

xmlFileList($MENU);
?>

<h1 class="py-6 text-center text-5xl">Drinky</h1>

<div class="bg-zinc-50 flex justify-center">
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
    <?= xmlTransform("$MENU/$drink.xml", "$XML/recept.xsl") ?>
<?php } ?>

<?php require "$INC/foot.php";
