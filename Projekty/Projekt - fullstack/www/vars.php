<?php
// globální proměnné

// adresáře
$INC = __DIR__ . '/include';        // include files
$XML = __DIR__ . '/xml';            // XML files
$DRINKS = '/var/mixolog/drinks';    // uploaded data

// stránky
$title = 'Mixolog';

// uživatel
$jmeno = @$_SESSION['jmeno'];

// pomocníci
function prolog($withNav = true)
{
    global $INC;
    require "$INC/prolog.php";
    if ($withNav)
        require "$INC/nav.php";
}

function epilog()
{
    global $INC, $title;
    require "$INC/epilog.php";
}


function isLoggedIn()
{
    global $jmeno;
    return !!$jmeno;
}
