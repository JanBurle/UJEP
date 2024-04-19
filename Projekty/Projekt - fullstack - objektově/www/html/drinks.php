<?php require '../page.php';
require '../db.php';
require '../xmlTools.php';

$page->htmlBegin();
$page->nav();

// vypsat drinky
?>

<h1 class="py-6 text-center text-5xl">Drinky</h1>

<div class="bg-zinc-50 flex justify-center">
    <ol class="fa-ul">
        <?php foreach (xmlFileList(DRINKS) as $basename) { ?>
            <li>
                <i class="fa fa-li fa-glass"></i>
                <a class="hover:underline" href="?drink=<?= $basename ?>">
                    <?= $basename ?> (<?= precteno($basename) ?>)
                </a>
            </li>
        <?php } ?>
    </ol>
</div>

<?php
// zvolený drink
if ($drink = @$_GET['drink']) {
    if (TRANSFORM_SERVER_SIDE) { ?>
        <?= xmlTransform(DRINKS . "/$drink.xml", XML . '/recept.xsl') ?>
    <?php } else { ?>
        <h2 id="nazev" class="text-center text-2xl m-4" />
        <script>
            loadXML(
                "/getDrink.php?drink=<?= $drink ?>",
                (xmlDom) => {
                    console.log(xmlDom)
                    // zde pracovat s DOM ...
                    document.getElementById("nazev").innerHTML =
                        xmlDom.getElementsByTagName("název")[0].textContent;
                    // ...
                })
        </script>
    <?php }
} ?>

<?php $page->htmlEnd();