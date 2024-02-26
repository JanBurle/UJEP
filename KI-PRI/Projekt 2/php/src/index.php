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

    <p>Nahrajte XML soubor, případně také XSD soubor.</p>
    <hr>
    <form enctype="multipart/form-data" method="POST">
        <table>
            <tr>
                <td>XML soubor:</td>
                <td><input type="file" name="xml" accept="text/xml" data-max-file-size="2M"></td>
            </tr>
            <tr>
                <td>XSD soubor:</td>
                <td><input type="file" name="xsd" data-max-file-size="2M"></td>
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

    function validate($xmlPath, $xsdPath = '')
    {
        $doc = new DOMDocument;

        // proběhne kontrola well-formed
        libxml_use_internal_errors(true);
        $doc->loadXML(file_get_contents($xmlPath));
        printErrors();
        libxml_use_internal_errors(false);

        $isValid = false;
        // Máme XSD?
        if ($xsdPath) {
            echo '<p>Validuji podle XSD.';
            // validace
            libxml_use_internal_errors(true);
            $isValid = $doc->schemaValidate($xsdPath);
            printErrors();
            libxml_use_internal_errors(false);
        }

        return $isValid;
    }

    // poslané soubory
    $xmlFile = @$_FILES['xml'];
    $xsdFile = @$_FILES['xsd'];

    // Máme XML?
    if (@$xmlTmpName = $xmlFile['tmp_name']) {
        $xsdTmpName = $xsdFile['tmp_name'];
        $isValid = validate($xmlTmpName, $xsdTmpName);
        if ($isValid)
            echo "Nahraný XML soubor je validní.";
    }
    ?>
</body>

</html>