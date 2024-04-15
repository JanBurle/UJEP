# JavaScript + HTML DOM

### HTML DOM

Stromová struktura, vytvořená z HTML stránky, dále je ji možno manipulovat pomocí JS.
Je přístupná přes globální objekt `document` (`window.document`).
* [JavaScript HTML DOM](https://www.w3schools.com/js/js_htmldom.asp)
* [HTML DOM Documents](https://www.w3schools.com/jsref/dom_obj_document.asp)
* [JavaScript HTML DOM Document](https://www.w3schools.com/js/js_htmldom_document.asp)

Zpracování HTML stránky - je nutno počkat, až bude DOM hotov:
* [`1 - dom.html`](../../Projekty/JS%20Tutorial/www/html/HtmlDom/1%20-%20dom.html)

JS vyhledá elementy v DOM různým způsobem:
* [`2 - dom.html`](../../Projekty/JS%20Tutorial/www/html/HtmlDom/2%20-%20dom.html)

JS lze přidat přímo do elementu pro obsluhu událostí:
* [`3 - events.html`](../../Projekty/JS%20Tutorial/www/html/HtmlDom/3%20-%20elem.html)

Události lze také obsluhovat mimo element:
* [`4 - events.html`](../../Projekty/JS%20Tutorial/www/html/HtmlDom/3%20-%20elem.html)

### ❖ Úkol 9.1: Pexeso
* [`5 - events.html`](../../Projekty/JS%20Tutorial/www/html/HtmlDom/5%20-%20pexeso.html)

Dokončete tento příklad tak, aby při kliknutí na políčko tabulky se změnilo jeho pozadí (on/off). Zároveň se pod tabulku spočítá počet políček se změněným pozadím.

<!--
td.sel {
    background: gray;
}

<script>
    // zkratky
    let l = console.log
    let d = document

    d.addEventListener('DOMContentLoaded', () => {
        let tds = d.querySelectorAll('td')
        let span = d.querySelector('span')

        tds.countThem = () => {
            let count = 0
            tds.forEach((el) => el.classList.contains('sel') && ++count)
            span.innerHTML = count
        }

        tds.forEach(
            (el) =>
                (el.onclick = () => {
                    el.classList.toggle('sel')
                    tds.countThem()
                }),
        )
    })
</script>
-->
