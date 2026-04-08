<?php
// databázové funkce – místo SQL databáze používá XML soubor čtený přes SimpleXML

define('DATA_XML', VAR_DIR . '/data.xml');

$initData = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<mixolog>
    <uzivatele>
        <uzivatel jmeno="pavel" heslo="pavel"/>
        <uzivatel jmeno="alena" heslo="heslo"/>
        <uzivatel jmeno="petr" heslo="12345"/>
    </uzivatele>
    <drinky/>
</mixolog>
XML;

class Db
{
    private SimpleXMLElement $xml;

    function __construct()
    {
        if (file_exists(DATA_XML)) {
            $this->xml = simplexml_load_file(DATA_XML);
        } else {
            // výchozí data
            global $initData;
            $this->xml = simplexml_load_string($initData);
            $this->uloz();
        }
    }

    // uloží aktuální stav XML na disk
    private function uloz(): void
    {
        $this->xml->asXML(DATA_XML);
    }

    // autentikace uživatele
    function authUser(string $jmeno, string $heslo): bool
    {
        foreach ($this->xml->uzivatele->uzivatel as $uzivatel) {
            if ((string)$uzivatel['jmeno'] === $jmeno && (string)$uzivatel['heslo'] === $heslo)
                return true;
        }

        return false;
    }

    // sledujeme popularitu drinku
    function precteno(string $drink): int
    {
        // hledat existující záznam a inkrementovat
        foreach ($this->xml->drinky->drink as $d) {
            if ((string)$d['nazev'] === $drink) {
                $d['precteno'] = (int)$d['precteno'] + 1;
                $this->uloz();
                return (int)$d['precteno'];
            }
        }

        // nový záznam – první zobrazení
        $d = $this->xml->drinky->addChild('drink');
        $d->addAttribute('nazev', $drink);
        $d->addAttribute('precteno', 1);
        $this->uloz();
        return 1;
    }
}

// globální instance
$db = new Db();
