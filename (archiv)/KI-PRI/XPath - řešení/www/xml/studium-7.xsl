<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >

  <xsl:template match="/">
    semestry podle celkového počtu kreditních bodů
    <xsl:apply-templates select="//semestr">
      <xsl:sort select="sum(predmet/kredity)" data-type="number" order="descending"/>
    </xsl:apply-templates>
  </xsl:template>

  <xsl:template match="semestr">
    <p>
      <xsl:value-of select="../@cislo"/> - <xsl:value-of select="@nazev"/> - <xsl:value-of select="sum(predmet/kredity)"/>
    </p>
  </xsl:template>

</xsl:stylesheet>
