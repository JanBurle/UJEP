<?
function fileText($name) {
  // uploaded file
  if ($fileName = @(@$_FILES[$name])['tmp_name'])
    if ($text = file_get_contents($fileName) ?: '')
      return $text;

  // pasted text
  return $_REQUEST[$name] ?? '';
}

function validateWellFormed($xmlText) {
  libxml_use_internal_errors(true);

  $doc = new DOMDocument;
  $res = $doc->loadXML($xmlText);
  if (!$res)
    printErrors();

  libxml_use_internal_errors(false);

  // false or the document
  return $res ? $doc : false;
}

function printErrors() { ?>
  <hr>
  <table class="framed">
    <? foreach (libxml_get_errors() as $error) { ?>
      <tr>
        <td><?= $error->line ?></td>
        <td><?= htmlspecialchars(substr($error->message, 0, 80)) ?></td>
      </tr>
    <? } ?>
  </table>
  <hr>
<?
}

function printMessage($msg) { ?>
  <table class="framed">
    <tr>
      <td><?= $msg ?></td>
    </tr>
  </table>
<?
}

function isDTD($text) {
  // Check for a DTD-specific pattern
  return preg_match('/<!ELEMENT\s+[\w\-]+\s*\(/', $text);
}

function isXSD($text) {
  // Check for XSD-specific patterns
  $patterns = [
    '/<xs:schema[^>]*>/i',
    '/<xsd:schema[^>]*>/i',
  ];

  foreach ($patterns as $pattern) {
    if (preg_match($pattern, $text)) {
      return true;
    }
  }

  return false;
}

$xmlText = fileText('xml');
$valText = fileText('dtd/xsd');

function validateDTD($doc, $dtdText) {
  $root = $doc->firstElementChild->tagName;
  $systemId = 'data://text/plain;base64,' . base64_encode($dtdText);

  // inject DTD into XML
  $creator = new DOMImplementation;
  $doctype = $creator->createDocumentType($root, '', $systemId);
  $newDoc = $creator->createDocument(null, '', $doctype);
  $newDoc->encoding = "utf-8";

  $oldRootNode = $doc->getElementsByTagName($root)->item(0);
  $newRootNode = $newDoc->importNode($oldRootNode, true);

  $newDoc->appendChild($newRootNode);
  $doc = $newDoc;

  // validace
  libxml_use_internal_errors(true);

  $isValid = $doc->validate();
  if (!$isValid)
    printErrors();

  libxml_use_internal_errors(false);

  return $isValid;
}

function validateXSD($doc, $xsdText) {
  libxml_use_internal_errors(true);

  $isValid = @$doc->schemaValidateSource($xsdText);
  if (!$isValid)
    printErrors();

  libxml_use_internal_errors(false);

  return $isValid;
}

if ($xmlText) {
  $doc = validateWellFormed($xmlText);

  if ($doc)
    printMessage('XML is well-formed');

  if ($doc && $valText) {
    $isValid = false;

    if (isDTD($valText))
      $isValid = validateDTD($doc, $valText);
    else if (isXSD($valText))
      $isValid = validateXSD($doc, $valText);
    else
      printMessage('DTD or XSD is not recognized');

    if ($isValid)
      printMessage('XML is valid');
  }
}
