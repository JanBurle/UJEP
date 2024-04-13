<?xml version="1.0" encoding="UTF-8"?>
<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html"/>
    <xsl:template match="/">
        <main>
            <xsl:apply-templates />
        </main>
    </xsl:template>

    <!-- Výpis informací o drinku do tabulky -->
    <xsl:template match = "informace">
        <h1>
            <xsl:value-of select="název"/>
        </h1>
        <table class="table-auto">
            <tr>
                <td>Doba přípravy:</td>
                <td><xsl:value-of select="doba_přípravy"/> <xsl:value-of select="@jednotka"/></td>
            </tr>
            <tr>
                <xsl:choose>
                    <xsl:when test="země_původu">
                        <td>Země původu:</td><td><xsl:value-of select="země_původu"/></td>
                    </xsl:when>
                    <xsl:otherwise>
                        <td>Země původu:</td><td>neznámá</td>
                    </xsl:otherwise>
                </xsl:choose>
            </tr>
            <xsl:if test="obtížnost">
                <tr>
                    <td>Obtížnost:</td><td><xsl:value-of select ="name(obtížnost/*[1])"/></td>
                </tr>
            </xsl:if>
        </table>
    </xsl:template>

    <!-- výpis ingrediencí -->
    <xsl:template match = "ingredience">
        <h3>Ingredience:</h3>
        <ul>
            <xsl:for-each select="položka">
                <xsl:choose>
                    <xsl:when test="@typ='základ'">
                        <li>
                            <xsl:value-of select="."/>
                            <span>(<xsl:value-of select="@typ"/>)</span>
                        </li>
                    </xsl:when>
                    <xsl:when test="@typ='dochucovadlo'">
                        <li>
                            <xsl:value-of select="."/>
                            <span>(<xsl:value-of select="@typ"/>)</span>
                        </li>
                    </xsl:when>
                    <xsl:when test="@typ='dekorace'">
                        <li>
                            <xsl:value-of select="."/>
                            <span>(<xsl:value-of select="@typ"/>)</span>
                        </li>
                    </xsl:when>
                    <xsl:otherwise>
                        <li>
                            <xsl:value-of select="."/>
                        </li>
                    </xsl:otherwise>
                </xsl:choose>
            </xsl:for-each>
        </ul>
    </xsl:template>

    <!-- výpis postupu receptu -->
    <!-- <xsl:template match = "postup">
        <h3>Postup:</h3>
        <p>
            <xsl:value-of select="."/>
        </p>
    </xsl:template> -->

</xsl:transform>