<?php require __DIR__ . '/../vars.php';
prolog();

require "$INC/tools.php";

xmlFileList($DRINKS);
?>

<h1 class="py-6 text-center text-5xl">Drinky</h1>

<div class="bg-zinc-50 flex justify-center">
    <ol class="fa-ul">
        <?php foreach (xmlFileList($DRINKS) as $basename) { ?>
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
    <?= xmlTransform("$DRINKS/$drink.xml", "$XML/recept.xsl") ?>
<?php } ?>

<?php epilog();
