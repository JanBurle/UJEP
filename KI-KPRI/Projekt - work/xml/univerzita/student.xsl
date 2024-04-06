<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <html>
      <head>
        <title>Informace o studentech</title>
        <style>
          th, td{
            border-bottom: 1px solid;
            padding: 4px;
          }
        </style>
      </head>
      <body>
        <h1>Informace o studentech</h1>
        <table>
          <tr>
            <th>Číslo studenta</th>
            <th>Křestní jméno</th>
            <th>Příjmení</th>
            <th>Fakulta</th>
          </tr>
          <xsl:apply-templates select="studenti/student"/>
        </table>
      </body>
    </html>
  </xsl:template>
  <xsl:template match="student">
    <tr>
      <td>
        <xsl:value-of select="@st"/>
      </td>
      <td>
        <xsl:value-of select="jmeno"/>
      </td>
      <td>
        <xsl:value-of select="prijmeni"/>
      </td>
      <td>
        <xsl:value-of select="fakulta"/>
      </td>
    </tr>
  </xsl:template>
</xsl:stylesheet>