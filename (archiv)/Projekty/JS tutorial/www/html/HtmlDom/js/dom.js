let l = console.log

let listDom = () => {
    l('Elements')
    listElem(document.documentElement)

    l('Nodes')
    listNode(document)
}

let listElem = (elem) => {
    console.groupCollapsed(elem.tagName + ':', elem.constructor.name)

    for (attr of elem.attributes) l('attr:', attr)
    if (elem.classList.length) l('classes:', elem.classList.toString())

    for (let child of elem.children) listElem(child)

    l(elem.constructor.prototype)
    console.groupEnd()
}

let listNode = (node) => {
    console.groupCollapsed(node.nodeName + ':', node.constructor.name)

    let val = node.nodeValue
    if (val) val = val.trim() // no white space
    if (val) l('value:', val)

    for (let child of node.childNodes) listNode(child)

    l(node.constructor.prototype)
    console.groupEnd()
}

document.addEventListener('DOMContentLoaded', listDom)
