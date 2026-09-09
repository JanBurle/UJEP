<?
$s = <<<HEREDOC
<?xml version="1.0" encoding="UTF-8"?>
<studenti>
    <student st="98422" f="22156">
        <jmeno>Radek</jmeno>
        <prijmeni>Šmejkal</prijmeni>
        <fakulta>PŘF</fakulta>
    </student>
    <student st="98423" f="22157">
        <jmeno>Jiří</jmeno>
        <prijmeni>Novák</prijmeni>
        <fakulta>PŘF</fakulta>
    </student>
    <student st="98424" f="22158">
        <jmeno>Jan</jmeno>
        <prijmeni>Dvořák</prijmeni>
        <fakulta>FUD</fakulta>
    </student>
</studenti>
HEREDOC;

$xml = simplexml_load_string($s);

echo '<pre>';
print_r($xml);
echo '</pre>';
