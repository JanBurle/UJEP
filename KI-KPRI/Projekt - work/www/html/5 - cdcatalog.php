<!DOCTYPE html>
<html>

<head>
    <script>
        function loadXMLDoc(filename) {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", filename, false);
            xhr.send("");
            return xhr.responseXML;
        }

        function displayResult() {
            xml = loadXMLDoc("xml/CDs/cdcatalog.xml");
            xsl = loadXMLDoc("xml/CDs/cdcatalog.xsl");
            xslt = new XSLTProcessor();
            xslt.importStylesheet(xsl);
            result = xslt.transformToFragment(xml, document);
            document.getElementById("catalog").appendChild(result);
        }
    </script>
</head>

<body onload="displayResult()">
    <div id="catalog" />
</body>

</html>