<?
$s = <<<HEREDOC
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="fakulta.xsl"?>
<fakulty>
    <fakulta>
        <dekan>
            <jmeno>Michal</jmeno>
            <prijmeni>Varady</prijmeni>
            <email>m.v@gmail.com</email>
        </dekan>
        <katedry>
            <katedra>
                <nazev>KI</nazev>
                <zamestnanci>
                    <zamestnanec>
                        <jmeno>lorem</jmeno>
                        <prijmeni>lorem</prijmeni>
                        <email>lorem</email>
                    </zamestnanec>
                    <zamestnanec>
                        <jmeno>ipsum</jmeno>
                        <prijmeni>ipsum</prijmeni>
                        <email>ipsum</email>
                    </zamestnanec>
                </zamestnanci>
            </katedra>
        </katedry>
    </fakulta>
</fakulty>
HEREDOC;

$xml = simplexml_load_string($s);

echo '<pre>';
print_r($xml);
echo '</pre>';
