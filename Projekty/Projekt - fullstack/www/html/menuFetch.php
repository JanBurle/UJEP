<?php require __DIR__ . '/../vars.php';
prolog();

require "$INC/tools.php";

xmlFileList($DRINKS);
?>

<h1 class="py-6 text-center text-5xl">Drinky</h1>

<div class="bg-zinc-50 flex justify-center">
    <ol class="fa-ul">
        <?php foreach (xmlFileList($DRINKS) as $basename) { ?>
            <li>
                <i class="fa fa-li fa-glass"></i>
                <a class="hover:underline" href="" onclick="load('<?= $basename ?>'); return false">
                    <?= $basename ?>
                </a>
            </li>
        <?php } ?>
    </ol>
</div>

<div id="drink" />

<script>
    function load(name) {
        fetch(`/getxml.php?name=${name}`)
            .then(res => res.text())
            .then(text => parse(text))
    }

    function parse(text) {
        let doc = new DOMParser().parseFromString(text, "text/xml")
        console.log(doc)
        document.getElementById("drink").innerHTML =
            doc.getElementsByTagName("název")[0].textContent;
    }
</script>

<?php epilog();
