<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >

  <xsl:template match="/">
    předměty podle semestrů, pouze předměty s počtem kreditů &gt; 2
     <xsl:apply-templates select="//semestr"/>
  </xsl:template>

  <xsl:template match="semestr">
    <section>
      <xsl:value-of select="../@cislo"/>
      <xsl:text> </xsl:text>
      <xsl:value-of select="@nazev"/>
      <ul>
        <xsl:apply-templates select="predmet[kredity > 2]"/>
      </ul>
    </section>
  </xsl:template>

  <xsl:template match="predmet">
    <li><xsl:value-of select="nazev"/> - <xsl:value-of select="kredity"/></li>
  </xsl:template>

</xsl:stylesheet>
