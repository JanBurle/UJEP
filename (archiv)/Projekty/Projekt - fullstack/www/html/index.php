<?php // úvodní stránka:
require '../prolog.php';
require INC . '/html-begin.php';
require INC . '/nav.php';
?>

<style>
  p {
    margin-bottom: .6em;
  }
</style>

<main class='pb-10 m-6'>
  <h1 class="pb-6 text-5xl text-center">
    <?= TITLE ?>
  </h1>

  <p>
    Barmanská profese se děli na dva tábory. Jedni vám v roztrhaných džínách a ušmudlaném tričku
    nalijí panáka vodky za 30 Kč, jiní vám v pečlivě vyžehleném obleku s pěstovaným knírkem
    udělají pečlivě nalitý koktejl za 500 Kč. Ten druhý typ barmanů nazýváme mixology, praktikanty
    oboru mixologie, což je odborný termín pro tvorbu opravdu dobrých koktejlů.
  </p>

  <?= file_get_contents('http://loripsum.net/api/12/medium'); ?>

</main>

<?php require INC . '/html-end.php';
