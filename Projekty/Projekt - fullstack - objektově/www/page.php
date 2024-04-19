<?php
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

// application
class Page
{
    function htmlBegin()
    { ?>
        <!DOCTYPE html>
        <html lang="cs">

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
            <script src="https://cdn.tailwindcss.com"></script>
            <script src="./assets/ajax.js"></script>
            <title>
                <?= TITLE ?>
            </title>
        </head>

        <body>
            <?php
    }

    function htmlEnd()
    { ?>
            <footer class="fixed bottom-0 z-20 w-full p-4 bg-white border-t border-gray-200 shadow">
                <span>
                    <?= TITLE ?>
                </span>
                |
                <span class="text-sm text-gray-500">
                    <a href="https://github.com/JanBurle/UJEP/tree/main/Projekty/Projekt%20-%20fullstack" target="_source">
                        (source)
                    </a>
                </span>
            </footer>

        </body>

        </html> <?php
    }

    function pages()
    {
        // seznam stránek (href => title)
        $pages = [
            '/' => 'Home',
            '/login.php' => 'Přihlášení',
            '/drinks.php' => 'Receptář',
        ];

        // přihlášený uživatel smí nahrávat recepty
        if (isUser())
            $pages['/upload.php'] = 'Nahrát';

        return $pages;
    }

    function nav()
    { ?>
        <!-- top navigation bar -->
        <nav class="sticky top-0 bg-white border-gray-200 shadow-md">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <!-- logo & title -->
                <a href='/'>
                    <div class="flex">
                        <img src="./assets/drink.jpg" class="h-8 mr-3" />
                        <span class="text-2xl font-semibold whitespace-nowrap">
                            <?= TITLE . getJmeno(': ') ?>
                        </span>
                    </div>
                </a>

                <!-- hamburger menu (md:hidden) -->
                <button id="menu-toggle"
                    class="md:hidden inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                    <i class="fa fa-bars fa-lg"></i>
                </button>

                <!-- menu items -->
                <div class="hidden w-full md:block md:w-auto mr-3" id="menu">
                    <ul class="font-medium flex flex-col md:p-0 mt-4 border border-gray-100 rounded-lg md:flex-row md:mt-0">
                        <?php foreach ($this->pages() as $href => $title) { ?>
                            <li>
                                <a href="<?= $href ?>" class="block p-2 rounded text-blue-700 hover:bg-gray-100">
                                    <?= $title ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let menu = document.getElementById('menu');
                let toggleMenu = () => menu.classList.toggle('hidden')

                let button = document.getElementById('menu-toggle');
                button.addEventListener('click', toggleMenu)
            });
        </script>
    <?php }

    // pro zobrazení chyby
    function errorBox($text)
    { ?>
        <div class="bg-red-100 border border-red-400 text-red-700 m-8 p-4 rounded">
            <?= $text ?>
        </div>

    <?php }

    // pro zobrazení úspěchu
    function successBox($text)
    { ?>
        <div class="bg-green-100 border border-green-400 text-green-700 m-8 p-4 rounded">
            <?= $text ?>
        </div>

    <?php }
}

$page = new Page();