<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <head>
                <meta charset="UTF-8"/>
                <title>Svi studenti - rezultati</title>
                <link href="style.css" rel="stylesheet" type="text/css"/>
                <link href="https://fonts.googleapis.com/css?family=Raleway:400,600,700,800" rel="stylesheet"/>
            </head>
            <body>
                <div id="wrapper">
                    <div id="menu-wrapper">
                        <div id="menu" class="container">
                            <ul>
                                <li><a href="index.php">🏠 Početna</a></li>
                                <li class="current_page_item"><a href="studenti.xml">📋 Svi studenti</a></li>
                                <li><a href="kontakt.html">📞 Kontakt</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="page" class="container">
                        <div class="title">
                            <h2>📋 Svi studenti i rezultati</h2>
                            <span class="byline">Pregled svih studenata i njihovih prosjeka</span>
                        </div>
                        <p style="text-align: center; font-size: 1.1em;">
                            Ukupno studenata: <strong><xsl:value-of select="count(//Student)"/></strong>
                        </p>
                        <div class="table-responsive">
                            <table class="rezultati-tablica">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ime</th>
                                        <th>Prezime</th>
                                        <th>Grupa</th>
                                        <th>Godina</th>
                                        <th>Prosjek</th>
                                        <th>Ocjena</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <xsl:for-each select="//Student">
                                        <xsl:sort select="Ime"/>
                                        <tr>
                                            <td><xsl:value-of select="position()"/></td>
                                            <td><xsl:value-of select="Ime"/></td>
                                            <td><xsl:value-of select="Prezime"/></td>
                                            <td><xsl:value-of select="Grupa"/></td>
                                            <td><xsl:value-of select="Godina"/></td>
                                            <td>
                                                <xsl:value-of select="round(sum(Kolokviji/Kolokvij) div count(Kolokviji/Kolokvij) * 100) div 100"/>
                                            </td>
                                            <td>
                                                <xsl:variable name="prosjek">
                                                    <xsl:value-of select="round(sum(Kolokviji/Kolokvij) div count(Kolokviji/Kolokvij) * 100) div 100"/>
                                                </xsl:variable>
                                                <xsl:choose>
                                                    <xsl:when test="$prosjek >= 27">Odličan (5)</xsl:when>
                                                    <xsl:when test="$prosjek >= 22">Vrlo dobar (4)</xsl:when>
                                                    <xsl:when test="$prosjek >= 17">Dobar (3)</xsl:when>
                                                    <xsl:when test="$prosjek >= 12">Dovoljan (2)</xsl:when>
                                                    <xsl:otherwise>Nedovoljan (1)</xsl:otherwise>
                                                </xsl:choose>
                                            </td>
                                        </tr>
                                    </xsl:for-each>
                                </tbody>
                            </table>
                        </div>
                        <div style="text-align: center; margin-top: 30px;">
                            <a href="index.php" class="button">🏠 Povratak na početnu</a>
                        </div>
                    </div>
                </div>
                <div id="copyright" class="container">
                    <p>© 2024 - Sustav za pregled rezultata kolokvija</p>
                </div>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>