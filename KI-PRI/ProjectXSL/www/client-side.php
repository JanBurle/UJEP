<!DOCTYPE html>
<html>

<head>
  <script>
    // complete the code: handle errors

    let fetchText = (fileName) =>
      fetch(fileName)
      .then(response => response.text())

    async function fetchCatalogFragment() {
      let texts = await Promise.all([fetchText('xml/cdcatalog.xml'), fetchText('xml/cdcatalog.xsl')])
      let [xml, xsl] = texts.map(text => new DOMParser().parseFromString(text, 'application/xml'))

      let xsltProc = new XSLTProcessor()
      xsltProc.importStylesheet(xsl)

      let frag = xsltProc.transformToFragment(xml, xsl)
      document.getElementById('catalog').appendChild(frag)
    }

    document.addEventListener("DOMContentLoaded", () => fetchCatalogFragment())
  </script>
</head>

<body>
  <div id="catalog"></div>
</body>

</html>
