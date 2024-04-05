<?php require __DIR__ . '/../inc/head.php';

require "$INC/nav.php";
require "$INC/xmlTools.php";

if (!$jmeno)
    die; ?>

<div class="flex justify-center m-12">
    <form class="bg-zinc-50 rounded px-8 pt-6 pb-8 mb-4" enctype="multipart/form-data" method="POST">
        <div class="mb-4">
            Nahrajte recept:
        </div>
        <div class="mb-4">
            <input title="tt" id="fileInput" name="xml" type="file" accept="text/xml" data-max-file-size="2M">
        </div>
        <input class="bg-blue-500 text-white font-bold rounded py-2 px-4" type="submit" value="Odeslat" />
    </form>
</div>

<?php

if ($xmlFile = @$_FILES['xml']['tmp_name']) {
    // $isValid = xmlValidateDTD($xmlFile, "$XML/recept.dtd");
    $isValid = xmlValidateXSD($xmlFile, "$XML/recept.xsd");
    if (!$isValid) { ?>
        <div class="bg-red-100 border border-red-400 text-red-700 m-8 p-4 rounded" role="alert">
            XML soubor není validní.
        </div>
    <?php }
}

require "$INC/foot.php";
