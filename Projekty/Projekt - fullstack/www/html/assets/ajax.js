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

// XHR nebo fetch?
let useXHR = true

// get data
let getXML = (url, processXML) =>
    (useXHR ? getXML_XHR : getXML_Fetch)(url, processXML)
