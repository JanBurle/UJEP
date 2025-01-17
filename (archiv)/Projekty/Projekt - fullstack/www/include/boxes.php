<?php
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