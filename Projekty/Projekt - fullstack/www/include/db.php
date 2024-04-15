<?php

// --- databázové funkce ---

// připojená databáze - vitální podmínka
$_db_ = mysqli_connect("database", "admin", "heslo", "mixolog") or die;

// dotaz na databázi
function dbQuery(string $query): bool|mysqli_result
{
    global $_db_;
    return @$_db_->query($query);
}

// bezpečné uzavření řetězu do uvozovek pro databázi
// databáze musí být připojená
function dbEscape(string $s): string
{
    global $_db_;
    return "'" . mysqli_real_escape_string($_db_, $s) . "'";
}

// --- uživatelské funkce nad databází ---

// autentikace uživatele
function authUser(string $jmeno, string $heslo): bool
{
    $jmeno = dbEscape($jmeno);
    $heslo = dbEscape($heslo);

    // připojení k databázi
    if ($result = dbQuery("select id from uzivatele where jmeno=$jmeno and heslo=$heslo"))
        if ($result->num_rows) {
            [[$id]] = $result->fetch_all();
            if ($id)
                return true;
        }


    return false;
}
