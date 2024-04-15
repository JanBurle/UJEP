<?php require __DIR__ . '/../prolog.php';
require INC . '/html-begin.php';
require INC . '/nav.php';
require INC . '/xmlTools.php';
?>

<h1 class="py-6 text-center text-5xl">Drinky</h1>

<div class="bg-zinc-50 flex justify-center">
    <ol class="fa-ul">
        <?php foreach (xmlFileList(DRINKS) as $basename) { ?>
            <li>
                <i class="fa fa-li fa-glass"></i>
                <a class="hover:underline" href="?drink=<?= $basename ?>">
                    <?= $basename ?>
                </a>
            </li>
        <?php } ?>
    </ol>
</div>

<?php
// jednotlivý drink

// kde generovat
$serverSide = true;

if ($drink = @$_GET['drink']) {
    if ($serverSide) { ?>
        <hr>
        <?= xmlTransform(DRINKS . "/$drink.xml", XML . '/recept.xsl') ?>
    <?php } else { /* client side - AJAX */ ?>
        <div id="drink" />
        <script>
            useXHR = true // XHR or Fetch
            getXML("/getDrinks.php?drink=<?= $drink ?>", (xmlDom) => {
                document.getElementById("drink").innerHTML =
                    xmlDom.getElementsByTagName("název")[0].textContent;
                // dále pracovat s DOM
                // ...
            })
        </script>
    <?php }
} ?>

<?php require INC . '/html-end.php';
