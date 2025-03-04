let l = console.log
let proto = (obj) => obj.constructor.prototype
let lp = (text, obj) => l(text, proto(obj), obj)

let d = document

let ctiKnihy = (xmlDoc) => {
  // máme tyto DOM:
  lp('HTML DOM:', d)
  lp('XML DOM:', xmlDoc)

  // v HTML DOM najdeme uzel
  let divKnihy = d.getElementById('knihy')
  l('DIV knihy:', divKnihy)

  // z XML DOM získáme seznam knih
  // https://www.w3schools.com/jsref/dom_obj_htmlcollection.asp
  let knihy = xmlDoc.getElementsByTagName('kniha')
  l('<kniha>*', knihy)

  // vytvoříme HTML list
  let ul = appendCreate(divKnihy, 'ul')

  for (let kniha of knihy) {
    // lp('kniha:', kniha)

    // XML DOM - data
    let nazev = kniha.getElementsByTagName('nazev')
    nazev = nazev[0].innerHTML

    // HTML list element
    let li = appendCreate(ul, 'li')
    li.appendChild(d.createTextNode(nazev))

    // JS obsluha DOM události
    li.addEventListener('click', () => li.classList.toggle('bold'))
  }
}

// helper function
let appendCreate = (parent, tag) => {
  let elem = d.createElement(tag)
  parent.appendChild(elem)
  return elem
}

// obsluha globální DOM události
let toggleBackground = () => d.body.classList.toggle('dark')
window.addEventListener('keydown', toggleBackground)

let processDOM = ctiKnihy
