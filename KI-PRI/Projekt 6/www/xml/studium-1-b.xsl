<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >

  <xsl:template match="/">
    <html>
      <body>
        <xsl:apply-templates select="//semestr"/>
      </body>
    </html>
  </xsl:template>

  <xsl:template match="semestr">
    <ul>
      <xsl:for-each select="predmet">
        <li>
          <xsl:value-of select="@katedra"/>/<xsl:value-of select="@kod"/>
        </li>
      </xsl:for-each>
    </ul>
  </xsl:template>

</xsl:stylesheet>
