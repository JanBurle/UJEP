<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >

  <xsl:template match="/">
    <html>
      <head>
        <title>Univerzita</title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
      </head>
      <body class="w3-light-grey">
        <div class="w3-content w3-margin">
          <h1 class="w3-text-teal">Univerzita</h1>
          <xsl:apply-templates select="fakulty/fakulta"/>
        </div>
      </body>
    </html>
  </xsl:template>

  <xsl:template match="fakulta">
    <div class="w3-main w3-border-top w3-border-bottom">
      <h2>Fakulta:<xsl:value-of select="nazev"/></h2>
      <div class="w3-border w3-margin w3-padding">
        <h3>Děkan</h3>
        <ul>
          <li><i class="fa fa-id-card w3-margin-right"/><xsl:value-of select="dekan/jmeno"/>&#160;<xsl:value-of select="dekan/prijmeni"/>
            (<xsl:for-each select="dekan/tituly/titul">
              <xsl:value-of select="."/>
              <xsl:if test="position() != last()">, </xsl:if>
            </xsl:for-each>)
          </li>
          <li><i class="fa fa-phone w3-margin-right"/><xsl:value-of select="dekan/telefon"/></li>
          <li><i class="fa fa-envelope w3-margin-right"/><xsl:value-of select="dekan/email"/></li>
        </ul>
      </div>

      <xsl:apply-templates select="katedry/katedra"/>
    </div>
  </xsl:template>

  <xsl:template match="katedra">
    <h3>Katedra: <xsl:value-of select="nazev"/></h3>
    <div class="w3-border w3-margin w3-padding">
      <h3>Vedoucí</h3>
      <ul>
        <li><i class="fa fa-id-card w3-margin-right"/><xsl:value-of select="vedouci/jmeno"/>&#160;<xsl:value-of select="vedouci/prijmeni"/>
          (<xsl:for-each select="vedouci/tituly/titul">
            <xsl:value-of select="."/>
            <xsl:if test="position() != last()">, </xsl:if>
          </xsl:for-each>)
        </li>
        <li><i class="fa fa-phone w3-margin-right"/><xsl:value-of select="vedouci/telefon"/></li>
        <li><i class="fa fa-envelope w3-margin-right"/><xsl:value-of select="vedouci/email"/></li>
      </ul>
    </div>

    <div class="w3-border w3-margin w3-padding">
      <h4>Zaměstnanci</h4>
      <table class="w3-table w3-bordered">
        <tr>
          <th><i class="fa fa-id-card w3-margin-right"/></th>
          <th><i class="fa fa-info w3-margin-right"/></th>
          <th><i class="fa fa-phone w3-margin-right"/></th>
          <th><i class="fa fa-envelope w3-margin-right"/></th>
          <th><i class="fa fa-mortar-board w3-margin-right"/></th>
        </tr>
        <xsl:for-each select="zamestnanci/zamestnanec">
          <tr>
            <td><xsl:value-of select="jmeno"/>&#160;<xsl:value-of select="prijmeni"/></td>
            <td><xsl:value-of select="pozice"/></td>
            <td><xsl:value-of select="telefon"/></td>
            <td><xsl:value-of select="email"/></td>
            <td>
              <xsl:for-each select="tituly/titul">
                <xsl:value-of select="."/>
                <xsl:if test="position() != last()">, </xsl:if>
              </xsl:for-each>
            </td>
          </tr>
        </xsl:for-each>
      </table>

      <h4>Předměty</h4>
      <ul>
        <xsl:for-each select="predmety/predmet">
          <li><xsl:value-of select="@zkratka"/> - <xsl:value-of select="nazev"/>
            <div>
              <xsl:value-of select="popis"/>
            </div>
          </li>
        </xsl:for-each>
      </ul>
    </div>
  </xsl:template>
</xsl:stylesheet>
