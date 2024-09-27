<?php
// každá webová stránka začíná prologem

// --- adresáře ---
define('INC', __DIR__ . '/include');        // include files
define('XML', __DIR__ . '/xml');            // XML files
define('DRINKS', '/var/mixolog/drinks');    // uploaded data

// --- konfigurace stránek ---
define('TITLE', 'Mixolog');

// kde transformovat XML
define('TRANSFORM_SERVER_SIDE', true);

// --- session ---
session_start();  // ze všeho nejdříve začít seanci, pak používat $_SESSION

// jméno přihlášeného uživatele (s prefixem) nebo ''
function getJmeno($prefix = ''): string
{
    $jmeno = @$_SESSION['jmeno'];
    return $jmeno ? "$prefix$jmeno" : '';
}

// nastav nebo smaž jméno přihlášeného uživatele
function setJmeno($jmeno = '')
{
    if ($jmeno)
        $_SESSION['jmeno'] = $jmeno;
    else
        unset($_SESSION['jmeno']);
}

// Je přihlášen uživatel?
function isUser(): bool
{
    return !!getJmeno();
}