<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >
  <xsl:output method="xml" indent="yes" version="1.0" />

  <xsl:template match="/studium">
    <predmety>
      <xsl:for-each select="//predmet">
        <xsl:copy-of select="."/>
      </xsl:for-each>
    </predmety>
  </xsl:template>

</xsl:stylesheet>
