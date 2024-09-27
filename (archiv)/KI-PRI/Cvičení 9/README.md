# JavaScript + HTML DOM

## HTML DOM

Stromová struktura, vytvořená z HTML stránky, dále je ji možno manipulovat pomocí JS:
* [JavaScript ⮕ HTML DOM](https://www.w3schools.com/js/js_htmldom.asp)

Přístup k DOM stránky v prohlížeči je přes globální objekt `document` (window.document):
* [HTML DOM `document` object](https://www.w3schools.com/jsref/dom_obj_document.asp)

Pomocí objektu `document` lze:
* [JavaScript HTML DOM Document](https://www.w3schools.com/js/js_htmldom_document.asp)
    * vyhledat elementy ve stránce – podle *id*, značky, CSS třídy
    * elementy měnit – (jejich HTML, atributy, styl, ...)
    * elementy přidávat a ubírat
    * přidávat JS pro obsluhu událostí
    * ... atd.

### Otevírání HTML stránky
Je nutno počkat, až bude DOM hotov:
* [`1 - dom.html`](../../Projekty/JS%20tutorial/www/html/HtmlDom/1%20-%20dom.html)

Příklad výpisu celého stromu::
* [`2 - dom.html`](../../Projekty/JS%20tutorial/www/html/HtmlDom/2%20-%20dom.html)

### Vyhledávání elementů

JS vyhledá elementy v DOM různým způsobem:
* [`3 - dom.html`](../../Projekty/JS%20tutorial/www/html/HtmlDom/3%20-%20dom.html)

### Obsluha událostí

JS lze přidat přímo do elementu pro obsluhu událostí:
* [`4 - events.html`](../../Projekty/JS%20tutorial/www/html/HtmlDom/4%20-%20events.html)

Události lze také obsluhovat mimo element:
* [`5 - events.html`](../../Projekty/JS%20tutorial/www/html/HtmlDom/5%20-%20events.html)

### ❖ Úkol 9.1: Pexeso
* [`6 - pexeso.html`](../../Projekty/JS%20tutorial/www/html/HtmlDom/6%20-%20pexeso.html)

Dokončete tento příklad tak, aby při kliknutí na políčko tabulky se změnilo jeho pozadí (on/off). Zároveň se pod tabulku spočítá počet políček se změněným pozadím.

### ❖ Úkol 9.2: Pexeso
* [`7 - pexeso.html`](../../Projekty/JS%20tutorial/www/html/HtmlDom/7%20-%20pexeso.html)

V tomto příkladě se tabulka vytvoří dynamicky. Upravte kód tak, aby každé kliknuté políčko z tabulky zmizelo.

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
