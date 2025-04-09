<?php

function tabulkaPredmetu($kodPredmetu)
{
    $xml = new DOMDocument;
    $xml->load('../../xml-aside/studium.xml');

    $xsl = new DOMDocument;
    $xsl->load("../../xml-aside/studium-predmet.xsl");

    $xslt = new XSLTProcessor();
    $xslt->importStylesheet($xsl);

    $xslt->setParameter('', 'kodPredmetu', $kodPredmetu);

    return $xslt->transformToXml($xml);
}

