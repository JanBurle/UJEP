<?php
// databázové funkce

class Db
{
    private $db;

    function __construct()
    {
        // připojí databázi - vitální!
        $this->db = mysqli_connect("database", "admin", "heslo", "mixolog") or die;
    }

    // dotaz k databázi
    function query(string $query): bool|mysqli_result
    {
        return @$this->db->query($query);
    }

    // bezpečné uzavření řetězu do uvozovek pro SQL
    function escape(string $s): string
    {
        return "'" . mysqli_real_escape_string($this->db, $s) . "'";
    }

    // autentikace uživatele
    function authUser(string $jmeno, string $heslo): bool
    {
        $jmeno = $this->escape($jmeno);
        $heslo = $this->escape($heslo);

        if ($result = $this->query("select id from uzivatele where jmeno=$jmeno and heslo=$heslo")) {
            if ($result->num_rows) {
                // fetch_all() vrací pole polí (řádky, a každá má políčka)
                // [[$id]] je dekonstrukce: vezme první hodnotu z první řádky
                [[$id]] = $result->fetch_all();
                if ($id)
                    return true;
            }
        }

        return false;
    }

    // sledujeme popularitu drinku
    function precteno(string $drink): int
    {
        $drink = $this->escape($drink);

        $this->query("insert into drinky (nazev, precteno) value($drink, 1) on duplicate key update precteno = precteno+1");
        $result = $this->query("select precteno from drinky where nazev=$drink");
        // opět dekonstrukce
        [[$precteno]] = $result->fetch_all();
        return $precteno;
    }
}

// globální instance, připojená k databázi
$db = new Db();