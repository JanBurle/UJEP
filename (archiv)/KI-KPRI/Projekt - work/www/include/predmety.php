<?php

function tabulkaPredmetu($kodPredmetu)
{
    $xml = new DOMDocument;
    $xml->load('../../xml-side/studium.xml');

    $xsl = new DOMDocument;
    $xsl->load("../../xml-side/studium-predmet.xsl");

    $xslt = new XSLTProcessor();
    $xslt->importStylesheet($xsl);

    $xslt->setParameter('', 'kodPredmetu', $kodPredmetu);

    return $xslt->transformToXml($xml);
}

