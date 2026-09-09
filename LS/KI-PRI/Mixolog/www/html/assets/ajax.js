// asynchronously load XML data from url
// when received, process with processXMLDOM

// use AJAX (XHR)
let loadXML_XHR = (url, processXMLDOM) => {
  let req = new XMLHttpRequest()
  req.onload = () => processXMLDOM(req.responseXML)
  req.open('GET', url)
  req.send()
}

// Fetch
let loadXML_Fetch = (url, processXMLDOM) => {
  let fetchXML = (url) => fetch(url).then((response) => response.text())
  let parseXML = (text) => new DOMParser().parseFromString(text, 'text/xml')

  fetchXML(url).then(parseXML).then(processXMLDOM)
}

// Použít XHR nebo fetch?
let USE_XHR = true

let loadXML = USE_XHR ? loadXML_XHR : loadXML_Fetch
