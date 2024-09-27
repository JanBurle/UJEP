<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >

  <xsl:template match="/">
    Seznam předmětů v posledním semestru.
    <main>
      <hr/>
      v pořadí, v jakém jsou v XML souboru
      <table>
        <xsl:apply-templates select="//rocnik[last()]/semestr[last()]/predmet"/>
      </table>
      <hr/>
      seřazené podle kódu předmětu
      <table>
        <xsl:apply-templates select="//rocnik[last()]/semestr[last()]/predmet">
          <xsl:sort select="@kod" order="ascending"/>
        </xsl:apply-templates>
      </table>
      <hr/>
      seřazené podle počtu kreditů
      <table>
        <xsl:apply-templates select="//rocnik[last()]/semestr[last()]/predmet">
          <xsl:sort select="kredity" data-type="number" order="descending"/>
        </xsl:apply-templates>
      </table>
      <hr/>
      <xsl:variable name="totalCredits">
          <xsl:value-of select="sum(//rocnik[last()]/semestr[last()]/predmet/kredity)"/>
      </xsl:variable>
      <p>Celkem kreditních bodů = <xsl:value-of select="$totalCredits"/></p>
    </main>
  </xsl:template>

  <xsl:template match="predmet">
    <tr>
      <td><xsl:value-of select="@kod"/></td>
      <td><xsl:value-of select="nazev"/></td>
      <td><xsl:value-of select="@katedra"/></td>
      <td><xsl:value-of select="vyucujici/jmeno"/></td>
      <td><xsl:value-of select="vyucujici/telefon"/></td>
      <td><xsl:value-of select="vyucujici/email"/></td>
      <td><xsl:value-of select="kredity"/></td>
      <td><xsl:value-of select="status"/></td>
      <td><xsl:value-of select="zakonceni"/></td>
    </tr>
  </xsl:template>
</xsl:stylesheet>
