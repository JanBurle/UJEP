<!DOCTYPE html>
<html>

<head>
</head>

<body>
<pre>

<?php
$xmlDoc = new DOMDocument();
$xmlDoc->loadXML(<<<HEREDOC
<?xml version="1.0" encoding="UTF-8"?>
<knihy>
    <kniha>
        <nazev>Epos o Berygamešovi</nazev>
        <autor>Jiří Fišer</autor>
        <postavy>
            <postava>Berygameš</postava>
            <postava>Škvorkidu</postava>
        </postavy>
    </kniha>
    <kniha>
        <nazev>Pán prstenů: návrat Fišera</nazev>
        <autor>Beránek Pavel</autor>
        <popis>
            Kniha o partě ajťáků, kteří se chystají na výpravu na zápočet na Fakultu Osudu.
        </popis>
    </kniha>
</knihy>
HEREDOC
);

echo htmlspecialchars($xmlDoc->saveXML());
?>

</pre>
</body>

</html>