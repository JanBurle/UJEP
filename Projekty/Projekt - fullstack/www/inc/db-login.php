<?php

function dbLogin($jmeno, $heslo)
{
    // připojení k databázi
    if ($db = mysqli_connect("database", "admin", "heslo", "mixolog")) {
        $result = @$db->query("select id from uzivatele where jmeno='$jmeno' and heslo='$heslo'");
        if ($result->num_rows) {
            [[$id]] = $result->fetch_all();
            if ($id)
                return [$id, $jmeno];
        }
    }

    return [0, ''];
}

