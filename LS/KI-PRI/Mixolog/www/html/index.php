<?php // úvodní stránka:
require '../page.php';
$page->htmlBegin();
$page->nav();
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

  <?php
  $json = file_get_contents('https://lorem.place/api/generate?p=3&w=46&html=true');

  $payload = json_decode($json, true);
  $paragraphs = $payload['data']['paragraphs'] ?? '';
  foreach ($paragraphs as $paragraph) {
    echo "<p>$paragraph</p>";
  }
  ?>

</main>

<?php $page->htmlEnd();
