<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >
<!-- Předměty v prvním semestru, předměty vyučované různými katedrami mají různé pozadí. -->

  <xsl:template match="/">
    <html>
      <head>
        <style>
          .KMA {background-color: yellow;}
          .CJP {background-color: cyan;}
          .KF  {background-color: red;}
          .KTV {background-color: green;}
          .KI {background-color:  gold;}
        </style>
      </head>
      <body><ul>
        <xsl:apply-templates select="//rocnik[1]/semestr[1]/predmet"/>
      </ul></body>
    </html>
  </xsl:template>

  <xsl:template match="predmet">
    <li class="{@katedra}">
      <xsl:value-of select="@katedra"/>/<xsl:value-of select="@kod"/>
      <xsl:text> </xsl:text>
      <xsl:value-of select="nazev"/>
    </li>
  </xsl:template>

</xsl:stylesheet>
