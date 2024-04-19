<?xml version="1.0" encoding="UTF-8"?>
<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html"/>
    <xsl:template match="/">
        <main class="bg-zinc-50 m-6">
            <xsl:apply-templates />
        </main>
    </xsl:template>

    <!-- Výpis informací o drinku do tabulky -->
    <xsl:template match = "informace">
        <h2 class="text-center text-2xl m-4">
            <xsl:value-of select="název"/>
        </h2>
        <table>
            <tr class="border">
                <td class="px-6">Doba přípravy:</td>
                <td class="px-6"><xsl:value-of select="doba_přípravy"/> <xsl:value-of select="doba_přípravy/@jednotka"/></td>
            </tr>
            <tr class="border">
                <td class="px-6">Země původu:</td>
                <xsl:choose>
                    <xsl:when test="země_původu">
                        <td class="px-6"><xsl:value-of select="země_původu"/></td>
                    </xsl:when>
                    <xsl:otherwise>
                        <td class="px-6">neznámá</td>
                    </xsl:otherwise>
                </xsl:choose>
            </tr>
            <xsl:if test="obtížnost">
            <tr class="border">
                    <td class="px-6">Obtížnost:</td>
                    <td class="px-6"><xsl:value-of select ="name(obtížnost/*[1])"/></td>
                </tr>
            </xsl:if>
        </table>
    </xsl:template>

    <!-- výpis ingrediencí -->
    <xsl:template match = "ingredience">
        <h2 class="text-center text-2xl m-4">
            Ingredience:
        </h2>
        <ul class="fa-ul">
            <xsl:for-each select="položka">
                <xsl:choose>
                    <xsl:when test="@typ='základ'">
                        <li>
                            <i class="fa fa-li fa-circle"></i>
                            <xsl:value-of select="."/>
                            <span>(<xsl:value-of select="@typ"/>)</span>
                        </li>
                    </xsl:when>
                    <xsl:when test="@typ='dochucovadlo'">
                        <li>
                            <i class="fa fa-li fa-plus-circle"></i>
                            <xsl:value-of select="."/>
                            <span>(<xsl:value-of select="@typ"/>)</span>
                        </li>
                    </xsl:when>
                    <xsl:when test="@typ='dekorace'">
                        <li>
                            <i class="fa fa-li fa-leaf"></i>
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
    <xsl:template match = "postup">
        <h2 class="text-center text-2xl m-4">
            Postup:
        </h2>
        <p>
            <xsl:value-of select="."/>
        </p>
    </xsl:template>

</xsl:transform>