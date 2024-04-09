let l = console.log
let d = document

// AJAX
let getKnihy = () => {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200) 
          ctiKnihy(this.responseXML)
    };

    xhr.open("GET", '/knihy.xml');
    xhr.send();
}

// fetch
// let getKnihy = () => {
//     fetch('/knihy.xml')
//     .then(res => res.text())
//     .then(text => 
//       ctiKnihy(new DOMParser().parseFromString(text, "text/xml"))
//     )
// }

let ctiKnihy = (xmlDoc) => {
  // l('HTML DOM:', d, d.constructor.prototype)
  // l('XML DOM:', xmlDoc, xmlDoc.constructor.prototype)

  let divKnihy = d.getElementById('knihy')
  // l('Knihy:', divKnihy)

  let xmlKnihy = xmlDoc.getElementsByTagName('kniha')
  // https://www.w3schools.com/jsref/dom_obj_htmlcollection.asp
  // l(xmlKnihy)

  let ul = d.createElement('ul');
  // l(ul)

  for (let xmlKniha of xmlKnihy) {
    // l(xmlKniha.constructor.prototype)

    let xmlNazev = xmlKniha.getElementsByTagName('nazev')
    // l(xmlNazev)
    
    let nazev = xmlNazev[0].innerHTML

    let li = d.createElement('li') 
    // l(li.constructor)
    // li.addEventListener('click', ()=>li.classList.toggle('bold'))

    li.appendChild(d.createTextNode(nazev))

    ul.appendChild(li)
  }

  divKnihy.appendChild(ul)
}

document.addEventListener('DOMContentLoaded', () => {  
  getKnihy()
})

