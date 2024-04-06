<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <html>
      <head>
        <title>Fakulty Univerzity</title>
        <style>
          .vert {
            width: 32%;
            float: left; 
          }
          .container:after {
            content: "";
            display: table;
            clear: both;
          }
          td, th {
            border-bottom: 1px solid;
            padding: 8px;
          }
          li {
            padding: 3px;
          }
          ul {
            padding-top: 8px;
          }
          hr {
            background-color: black;
            height: 2px;
          }
        </style>
      </head>
      <body>
        <h1>Fakulty Univerzity</h1>
        <div class="container">
          <xsl:apply-templates select="fakulty/fakulta"/>
        </div>
      </body>
    </html>
  </xsl:template>

  <xsl:template match="fakulta">
    <div class="vert">
      <h2>Fakulta</h2>
      <h3>Děkan</h3>
      <ul>
        <li>
          <xsl:value-of select="dekan/jmeno"/>
          <xsl:value-of select="dekan/prijmeni"/>
        </li>
        <li>Tel: <xsl:value-of select="dekan/telefon"/>
        </li>
        <li>Email: <xsl:value-of select="dekan/email"/>
        </li>
        <li> Tituly: <xsl:for-each select="dekan/tituly/titul">
          <xsl:value-of select="."/>
          <xsl:if test="position() != last()">, </xsl:if>
        </xsl:for-each>
      </li>
    </ul>
    <h3>Katedry</h3>
    <xsl:apply-templates select="katedry/katedra"/>
    <hr />
  </div>
</xsl:template>

<xsl:template match="katedra">
  <h3>
    <xsl:value-of select="nazev"/>
  </h3>
  <ul>
    <li>
      <strong>Vedoucí katedry:</strong>
      <xsl:value-of select="vedouci/jmeno"/>
      <xsl:value-of select="vedouci/prijmeni"/>
    </li>
    <li>
      <strong>Telefon vedoucího:</strong>
      <xsl:value-of select="vedouci/telefon"/>
    </li>
    <li>
      <strong>Email vedoucího:</strong>
      <xsl:value-of select="vedouci/email"/>
    </li>
    <li>
      <strong>Tituly vedoucího:</strong>
      <xsl:for-each select="vedouci/tituly/titul">
        <xsl:value-of select="."/>
        <xsl:if test="position() != last()">, </xsl:if>
      </xsl:for-each>
    </li>
  </ul>
  <h4>Zaměstnanci</h4>
  <table>
    <tr>
      <th>Jméno</th>
      <th>Příjmení</th>
      <th>Telefon</th>
      <th>Email</th>
      <th>Kontakt</th>
      <th>Pozice</th>
      <th>Tituly</th>
    </tr>
    <xsl:for-each select="zamestranci/zamestnanec">
      <tr>
        <td>
          <xsl:value-of select="jmeno"/>
        </td>
        <td>
          <xsl:value-of select="prijmeni"/>
        </td>
        <td>
          <xsl:value-of select="telefon"/>
        </td>
        <td>
          <xsl:value-of select="email"/>
        </td>
        <td>
          <xsl:value-of select="kontakt"/>
        </td>
        <td>
          <xsl:value-of select="pozice"/>
        </td>
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
      <li>
        <xsl:value-of select="nazev"/>
 -        <xsl:value-of select="@zkratka"/>
        <ul>
          <li>
            <xsl:value-of select="popis"/>
          </li>
        </ul>
      </li>
    </xsl:for-each>
  </ul>
</xsl:template>
</xsl:stylesheet>
