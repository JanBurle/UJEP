<?php
$pages = [
    '/' => 'Home',
    '/login.php' => 'Přihlášení',
    '/menu.php' => 'Receptář',
    '/menuXHR.php' => '(XHR)',
    '/menuFetch.php' => '(fetch)',
];

if ($jmeno) // přihlášen
    $pages['/upload.php'] = 'Nahrát';
?>

<!-- top navigation bar -->
<nav class="sticky top-0 bg-white border-gray-200 dark:bg-gray-900 shadow-md">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <!-- logo & title -->
        <a href='/'>
            <div class="flex items-center">
                <img src="./assets/drink.jpg" class="h-8 mr-3" alt="Mixolog Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">
                    <?= $title ?>
                    <?= $jmeno ? ": $jmeno" : '' ?>
                </span>
            </div>
        </a>
        <!-- hamburger -->
        <button id="navbar-toggle" data-collapse-toggle="navbar-default" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <i class="fa fa-solid fa-bars fa-lg"></i>
        </button>

        <!-- menu items -->
        <div class="hidden w-full md:block md:w-auto mr-3" id="navbar-default">
            <ul
                class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <?php foreach ($pages as $href => $text) { ?>
                    <li>
                        <a href="<?= $href ?>"
                            class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500">
                            <?= $text ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>