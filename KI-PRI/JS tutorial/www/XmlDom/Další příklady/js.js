let l = console.log
let proto = (obj) => obj.constructor.prototype
let lp = (obj) => l(proto(obj), obj)

let d = document

let loadXmlDoc = () =>
  new DOMParser().parseFromString(
    d.getElementById('xml-data').textContent,
    'text/xml'
  ).documentElement
