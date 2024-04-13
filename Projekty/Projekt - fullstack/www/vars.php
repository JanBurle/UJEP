<?php
// konfigurace + globální proměnné

// adresáře
define('INC', __DIR__ . '/include');    // include files
define('XML', __DIR__ . '/xml');        // XML files
define('DRINKS', '/var/mixolog/drinks');    // uploaded data

// stránky
define('TITLE', 'Mixolog');

// session - uživatel
session_start();

function getJmeno($prefix = '')
{
    $jmeno = @$_SESSION['jmeno'];
    return $jmeno ? "$prefix $jmeno" : $jmeno;
}

function setJmeno($jmeno = '')
{
    if ($jmeno)
        $_SESSION['jmeno'] = $jmeno;
    else
        unset($_SESSION['jmeno']);

    return $jmeno;
}

function isLoggedIn()
{
    return !!getJmeno();
}

// HTML helpers
function mods($mods = ['nav'])
{
    foreach ($mods as $mod)
        require INC . "/$mod.php";
}

function prolog($mods = ['nav'])
{
    require INC . '/prolog.php';
    mods($mods);
}

function epilog()
{
    require INC . '/epilog.php';
}
