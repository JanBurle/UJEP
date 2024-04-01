<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >
<!-- předměty podle semestrů, pouze předměty s počtem kreditů > 2 -->

  <xsl:template match="/">
    <html>
      <body>
        <xsl:apply-templates select="//semestr"/>
      </body>
    </html>
  </xsl:template>

  <xsl:template match="semestr">
    <p>
      <xsl:value-of select="../@cislo"/>
      <xsl:text> </xsl:text>
      <xsl:value-of select="@nazev"/>
      <ul>
        <xsl:apply-templates select="predmet[kredity > 2]"/>
      </ul>
    </p>
  </xsl:template>

  <xsl:template match="predmet">
    <li><xsl:value-of select="nazev"/> - <xsl:value-of select="kredity"/></li>
  </xsl:template>

</xsl:stylesheet>
