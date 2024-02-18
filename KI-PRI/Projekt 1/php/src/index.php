<!DOCTYPE html>
<html lang="cs">

<?php $title = 'XML validátor' ?>

<head>
    <title>
        <?= $title ?>
    </title>
</head>

<body>
    <h1>
        <?= $title ?>
    </h1>

    <p>Nahrajte validní XML soubor, případně DTD soubor.</p>

    <form enctype="multipart/form-data" method="POST">
        <table>
            <tr>
                <td>XML soubor:</td>
                <td><input type="file" name="xml" accept="text/xml" data-max-file-size="2M"></td>
            </tr>
            <tr>
                <td>DTD soubor:</td>
                <td><input type="file" name="dtd" data-max-file-size="2M"></td>
            </tr>
            <tr>
                <td>DTD kořen:</td>
                <td><input type="text" name="root"></td>
            </tr>
            <tr>
                <td><input type="submit" type="Odeslat"></td>
            </tr>
        </table>
    </form>

    <?php
    //
    function validateDoc($xmlPath, $dtdPath = '', $root = '')
    {
        $xml = file_get_contents($xmlPath);

        $doc = new DOMDocument;
        $doc->loadXML($xml);

        if ($dtdPath && $root) {
            $systemId = 'data://text/plain;base64,' . base64_encode(file_get_contents($dtdPath));

            print_r($doc->firstElementChild->tagName);
            $root=$doc->firstElementChild->tagName;

            $creator = new DOMImplementation;
            $doctype = $creator->createDocumentType($root, '', $systemId);
            $new = $creator->createDocument(null, '', $doctype);
            $new->encoding = "utf-8";

            $oldNode = $doc->getElementsByTagName($root)->item(0);
            $newNode = $new->importNode($oldNode, true);

            $new->appendChild($newNode);
            $doc = $new;
        }

        return $doc->validate();
    }

    if (@$xmlFile = $_FILES['xml']) { // máme XML?
        $xmlTmpName = $xmlFile['tmp_name'];

        $dtdFile = $_FILES['dtd'];
        $dtdTmpName = $dtdFile['tmp_name'];

        $root = @$_POST['root'];

        $valid = validateDoc($xmlTmpName, $dtdTmpName, $root);

        if ($valid) {
            echo '<p>Nahraný soubor je validní.</p>';
        }
        die;
    }

    ?>
</body>

</html>