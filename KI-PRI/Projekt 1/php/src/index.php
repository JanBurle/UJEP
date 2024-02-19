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

    <p>Nahrajte XML soubor, případně také DTD soubor.</p>
    <hr>
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
                <td></td>
                <td><input type="submit" type="Odeslat"></td>
            </tr>
        </table>
    </form>
    <hr>

    <?php
    function printErrors()
    { ?>
        <table>
            <?php foreach (libxml_get_errors() as $error) { ?>
                <tr>
                    <td>
                        <?= $error->line ?>
                    </td>
                    <td>
                        <?= $error->message ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?php
    }

    function validate($xmlPath, $dtdPath = '')
    {
        $doc = new DOMDocument;

        // proběhne kontrola well-formed
        libxml_use_internal_errors(true);
        $doc->loadXML(file_get_contents($xmlPath));
        printErrors();
        libxml_use_internal_errors(false);

        // Máme root a DTD?
        @$root = $doc->firstElementChild->tagName;
        if ($root && $dtdPath) {
            $root = $doc->firstElementChild->tagName;
            $systemId = 'data://text/plain;base64,' . base64_encode(file_get_contents($dtdPath));

            echo "<p>Validuji podle DTD. Kořen: <b>$root</b></p>";

            // inject DTD into XML
            $creator = new DOMImplementation;
            $doctype = $creator->createDocumentType($root, '', $systemId);
            $newDoc = $creator->createDocument(null, '', $doctype);
            $newDoc->encoding = "utf-8";

            $oldRootNode = $doc->getElementsByTagName($root)->item(0);
            $newRootNode = $newDoc->importNode($oldRootNode, true);

            $newDoc->appendChild($newRootNode);
            $doc = $newDoc;
        }

        // validace
        libxml_use_internal_errors(true);
        $isValid = $doc->validate();
        printErrors();
        libxml_use_internal_errors(false);

        return $isValid;
    }

    // poslané soubory
    $xmlFile = @$_FILES['xml'];
    $dtdFile = @$_FILES['dtd'];

    // Máme XML?
    if (@$xmlTmpName = $xmlFile['tmp_name']) {
        $dtdTmpName = $dtdFile['tmp_name'];
        $isValid = validate($xmlTmpName, $dtdTmpName);
        if ($isValid)
            echo "Nahraný XML soubor je validní.";
    }
    ?>
</body>

</html>