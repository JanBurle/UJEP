<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >
<!-- Seznam všech předmětů: kód + název, jako seznam. -->

  <xsl:template match="/">
    <html>
      <body><ul>
        <xsl:apply-templates select="//predmet"/>
      </ul></body>
    </html>
  </xsl:template>

  <xsl:template match="predmet">
    <li>
      <xsl:value-of select="@katedra"/>/<xsl:value-of select="@kod"/>
      <xsl:text> </xsl:text>
      <xsl:value-of select="nazev"/>
    </li>
  </xsl:template>

</xsl:stylesheet>
