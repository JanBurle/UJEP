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
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == XMLHttpRequest.DONE && this.status == 200)
                parse(this.responseXML);
        };

        xhr.open("GET", `/getxml.php?name=${name}`);
        xhr.send();
    }


    function parse(xml) {
        // console.log(xml)
        // console.log(xml.getElementsByTagName("název"))
        document.getElementById("drink").innerHTML =
            xml.getElementsByTagName("název")[0].textContent;
    }
</script>

<?php epilog();
