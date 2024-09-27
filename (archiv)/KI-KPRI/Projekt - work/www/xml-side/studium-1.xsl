<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >

  <xsl:template match="/">
    Seznam všech předmětů: kód + název, jako seznam.
    <ul>
        <xsl:apply-templates select="//predmet"/>
    </ul>
  </xsl:template>

  <xsl:template match="predmet">
    <li>
      <xsl:value-of select="@katedra"/>/<xsl:value-of select="@kod"/>
      <xsl:text> </xsl:text>
      <xsl:value-of select="nazev"/>
    </li>
  </xsl:template>

</xsl:stylesheet>
