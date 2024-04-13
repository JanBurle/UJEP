<?php
require INC . '/pages.php';
?>

<!-- top navigation bar -->
<nav class="sticky top-0 bg-white border-gray-200 shadow-md">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <!-- logo & title -->
        <a href='/'>
            <div class="flex">
                <img src="./assets/drink.jpg" class="h-8 mr-3" />
                <span class="text-2xl font-semibold whitespace-nowrap">
                    <?= TITLE . getJmeno(':') ?>
                </span>
            </div>
        </a>

        <!-- hamburger (md:hidden) -->
        <button id="navbar-toggle" data-collapse-toggle="navbar-default" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
            <i class="fa fa-bars fa-lg"></i>
        </button>

        <!-- menu items -->
        <div class="hidden w-full md:block md:w-auto mr-3" id="navbar-default">
            <ul class="font-medium flex flex-col md:p-0 mt-4 border border-gray-100 rounded-lg md:flex-row md:mt-0">
                <?php foreach ($pages as $href => $text) { ?>
                    <li>
                        <a href="<?= $href ?>" class="block p-2 rounded text-blue-700 hover:bg-gray-100">
                            <?= $text ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let menu = document.getElementById('navbar-default');
        let toggleMenu = () => menu.classList.toggle('hidden')

        let button = document.getElementById('navbar-toggle');
        button.addEventListener('click', toggleMenu)
    });
</script>