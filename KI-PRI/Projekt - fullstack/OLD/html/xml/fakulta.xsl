<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <html>
      <head>
        <title>Fakulty Univerzity</title>
        <style>
          td, th {
            border-bottom: 1px solid;
            padding: 8px;
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
    <div>
      <h2>Fakulta</h2>
      <h3>Děkan</h3>
      <ul>
        <li>
          <xsl:value-of select="dekan/jmeno"/>
          <xsl:value-of select="dekan/prijmeni"/>
        </li>
        <li>Email: <xsl:value-of select="dekan/email"/>
        </li>
      </ul>
      <h3>Katedry</h3>
      <xsl:apply-templates select="katedry/katedra"/>
    </div>
  </xsl:template>

  <xsl:template match="katedra">
    <h3>
      <xsl:value-of select="nazev"/>
    </h3>
    <h4>Zaměstnanci</h4>
    <table>
      <tr>
        <th>Jméno</th>
        <th>Příjmení</th>
        <th>Email</th>
      </tr>
      <xsl:for-each select="zamestnanci/zamestnanec">
        <tr>
          <td>
            <xsl:value-of select="jmeno"/>
          </td>
          <td>
            <xsl:value-of select="prijmeni"/>
          </td>
          <td>
            <xsl:value-of select="email"/>
          </td>
        </tr>
      </xsl:for-each>
    </table>
  </xsl:template>
</xsl:stylesheet>
