let l = console.log
let d = document

// AJAX
let getXML_XHR = (url, processXML) => {
    let xhr = new XMLHttpRequest()

    // obsluha asynchronní události
    xhr.onreadystatechange = () => {
        if (XMLHttpRequest.DONE == xhr.readyState && 200 == xhr.status)
            processXML(xhr.responseXML)
    }

    xhr.open('GET', url)
    xhr.send()
}

// Fetch
let getXML_Fetch = (url, processXML) => {
    // cascading promises
    fetch(url)
        .then((res) => res.text())
        .then((text) =>
            processXML(new DOMParser().parseFromString(text, 'text/xml')),
        )
}

// build page
document.addEventListener('DOMContentLoaded', () => {
    getKnihy('/xml/knihy.xml', ctiKnihy)
})

// XHR nebo fetch?
let useXHR = true

// get data
let getKnihy = (url, processXML) =>
    (useXHR ? getXML_XHR : getXML_Fetch)(url, processXML)

// helper function
let appendCreate = (parent, tag) => {
    let elem = d.createElement(tag)
    parent.appendChild(elem)
    return elem
}

// process data
let ctiKnihy = (xmlDoc) => {
    // máme tyto DOM:
    l('HTML DOM:', d.constructor.prototype, d)
    l('XML DOM:', xmlDoc.constructor.prototype, xmlDoc)

    // v HTML DOM najdeme uzel
    let divKnihy = d.getElementById('knihy')
    l('DIV knihy:', divKnihy)

    // z XML DOM získáme seznam knih
    // https://www.w3schools.com/jsref/dom_obj_htmlcollection.asp
    let xmlKnihy = xmlDoc.getElementsByTagName('kniha')
    l('<kniha>*', xmlKnihy)

    // HTML list
    let ul = appendCreate(divKnihy, 'ul')

    for (let xmlKniha of xmlKnihy) {
        l('Kniha:', xmlKniha.constructor.prototype, xmlKniha)

        // XML DOM - read data
        let xmlNazev = xmlKniha.getElementsByTagName('nazev')
        let nazev = xmlNazev[0].innerHTML

        // HTML DOM
        let li = appendCreate(ul, 'li')
        li.appendChild(d.createTextNode(nazev))

        // JS obsluha DOM události
        li.addEventListener('click', () => li.classList.toggle('bold'))
    }
}

let toggleBackground = () => d.body.classList.toggle('dark')

// obsluha globální DOM události
window.addEventListener('keydown', toggleBackground)
