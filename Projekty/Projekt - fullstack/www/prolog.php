<?php
// každá webová stránka začne prologem

// --- adresáře ---
define('INC', __DIR__ . '/include');        // include files
define('XML', __DIR__ . '/xml');            // XML files
define('DRINKS', '/var/mixolog/drinks');    // uploaded data

// --- konfigurace stránek ---
define('TITLE', 'Mixolog');

// --- session ---
session_start();  // ze všeho nejdříve nastartovat

// jméno přihlášeného uživatele nebo ''
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

// je uživatel přihlášen
function isUser(): bool
{
    return !!getJmeno();
}