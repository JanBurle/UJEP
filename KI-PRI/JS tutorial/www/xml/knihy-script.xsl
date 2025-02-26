<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:template match="/">
    <html>
      <head>
        <xsl:value-of select="//label[@id='MyScript']/text()" disable-output-escaping="yes"/>
      </head>
      <body>
        <h2>Knihy</h2>
        <xsl:for-each select="//kniha">
          <xsl:value-of select="nazev"/>
        </xsl:for-each>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
