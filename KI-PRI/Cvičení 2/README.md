# Cvičení 2 – XML-Schéma

Dnes se seznámíte s tvorbou komplexnějších XML schémat v jazyce XML.

### Předchozí cvičení:

V minulém cvičení jste:
* Nainstalovali vývojové prostředí (Docker Desktop, VSCode) a zprovoznili jednoduchou webovou stránku v Docker kontejneru s LAMP, která ověřuje, zda nahraný XML soubor je dobře strukturovaný (well-formed), případně soubor validuje pomocí nahraného DTD souboru.
* Seznámili jste se s jazykem XML – s elementy (značkami), atributy a jmennými prostory.
* Vytvořili jste XML soubor `student.xml` s informacemi o studentu naší univerzity.
* Opravili jste zadaný soubor `knihy.xml` tak, aby byl well-formed.
* Navrhli jste strukturu vašich XML dokumentů pro záznam informací o studentech a fakultě.
* Vytvořili jste XML soubor s informacemi o fakultě UJEP (`prf.xml`, `pf.xml` nebo `fakulta.xml`) tak, aby odpovídal zadané specifikaci `fakulta.dtd`.

### Obsah tohoto cvičení:
* XML služby
* Psaní schémat jazykem DTD
* Psaní schémat jazykem XSD
* Validace pomocí XSD v PHP

## XML služby

XML se používá pro předávání dat mezi servery (které poskytují služby) a klientskými aplikacemi (které tyto služby využívají). Mezi základní XML formáty, které jsou používány pro [XML služby](https://www.w3schools.com/xml/xml_services.asp), patří:

* [XML WSDL](https://w3schools.com/xml/xml_wsdl.asp) (*Web Services Description Language*) – popisuje webovou službu, kde ji najít a jak se k ní připojit, jaké datové typy používá ve zprávách, jaké operace poskytuje, a jaký je protokol (posloupnost) komunikace. WSDL se používá společně se SOAP.
* [XML SOAP](https://w3schools.com/xml/xml_soap.asp) (*Simple Object Access Protocol*) – formát a protokol pro výměnu dat mezi systémy a volání vzdálených procedur pomocí HTTP požadavků, čistě v XML (na rozdíl od jiných typů podobných služeb, jako je např. [CORBA](https://en.wikipedia.org/wiki/Common_Object_Request_Broker_Architecture)).
* [XML RDF](https://w3schools.com/xml/xml_rdf.asp) (*Resource Description Framework*) – formát pro popis webových metadat (pro tzv. sémantický web).
* [XML RSS](https://w3schools.com/xml/xml_rss.asp) (*Really Simple Syndication*) – formát pro syndikaci webového obsahu – pro zasílání krátkých upozornění odběratelům (typicky do aplikací typu RSS čtečka).

---
* tutorialspoint.com: [WSDL](https://www.tutorialspoint.com/wsdl/), [SOAP](https://www.tutorialspoint.com/soap/), [RSS](https://www.tutorialspoint.com/rss/)
* [ukázka WDSL](https://en.wikipedia.org/wiki/Web_Services_Description_Language)
* více o SOAP : [guru99.com](https://guru99.com/soap-simple-object-access-protocol.html) a [tutorial z MUNI](https://dior.ics.muni.cz/~makub/soap/tutorial.html)
* více o RDF : [linkeddatatools.com](https://linkeddatatools.com/semantic-web-basics) a [5star open data](https://5stardata.info/en/)
* více o RSS : [mnot.net](https://mnot.net/rss/tutorial)

### ❖ Úkol 2.1: RSS
Prozkoumejte strukturu nějakého RSS zdroje (*RSS feed*), jako je např. [https://news.bitcoin.com/feed](https://news.bitcoin.com/feed/) nebo jeden z [https://www.ceskenoviny.cz/rss/](https://www.ceskenoviny.cz/rss/). Mnoho RSS zdrojů najdete na [rss.feedspot.com](https://rss.feedspot.com/) nebo také [podle návodu](https://rss.app/blog/the-ultimate-guide-to-rss-feeds-in-2022-Rrxcde).

Uložte RSS XML do souboru a ověřte (v našem validátoru), zda je well-formed.

Zobrazte RSS feed v nějaké RSS čtečce, např. v [rssviewer.app](https://rssviewer.app/).

## Jazyk XSD

XSD (XML Schema Definiton) je alternativa k šabloně v DTD (document type definition) formátu. Tento způsob psaní schémat je složitější, ale i mocnější, než DTD.
- Popis [W3Schools XML Schema](https://w3schools.com/xml/xml_schema.asp)
- Porovnání XSD a DTD schémat: [W3Schools XSD How To](https://w3schools.com/xml/schema_howto.asp)

### XSD Simple elements

Základní stavební bloky XSD dokumentu jsou:
1. Kořen [W3Schools XSD &lt;schema>](https://w3schools.com/xml/schema_schema.asp) – každý XSD potřebuje kořenový element, v něm se mohou nacházet definice jmenných prostorů.
2. elementy [W3Schools XSD Elements](https://w3schools.com/xml/schema_simple.asp) – jsou dvou typů a to *simple* a *complex*; simple obsahují data v primitivních datových typech jako jsou string, decimal, integer, boolean, date a time; complex obsahují další elementy nebo atributy.
3. Atributy [W3Schools XSD Attributes](https://w3schools.com/xml/schema_simple_attributes.asp) – obsahují data o stejných typech jako simple elementy a mohou být implicitní (default), pevně dané (fixed) a vyžadované (required) a dělají z elementu komplexní typ.
4. Restrikce (omezení) [W3Schools XSD Restrictions](https://w3schools.com/xml/schema_facets.asp) – určují rozsah nebo výčet hodnot, kterých musí data elementů a atributů nabývat
5. Data – jsou typu [string](https://w3schools.com/xml/schema_dtypes_string.asp), [date](https://w3schools.com/xml/schema_dtypes_date.asp), [numeric](https://w3schools.com/xml/schema_dtypes_numeric.asp), [misc](https://w3schools.com/xml/schema_dtypes_misc.asp) (boolean, binary, anyURI, double, float, atd.)

### XSD Complex elements

Komplexní element v XSD je element, který obsahuje další elementy, atribut a/nebo restrikce [W3Schools XSD Complex](https://w3schools.com/xml/schema_complex.asp). Komplexn9 elementy dělíme na:
1. Prázdné elementy [W3Schools XSD Empty](https://w3schools.com/xml/schema_complex_empty.asp) – elementy bez obsahu, které ale mohou mít atributy (takže mohou obsahovat data).
2. Pouze-elementy [W3Schools XSD Elements Only](https://w3schools.com/xml/schema_complex_elements.asp) – element nebo sekvence elementů, která může být pojmenovaná
3. Pouze s textem [W3Schools XSD Text Only](https://w3schools.com/xml/schema_complex_text.asp) – jednoduchý element s rozšířením nebo restrikcí
4. Smíšené [W3Schools XSD Mixed](https://w3schools.com/xml/schema_complex_mixed.asp) – kombinace předchozích

### XSD Indikátory

Jazyk XSD obsahuje mechanismus indikátorů, které jsou určené k tomu, aby řídily způsob používání XML elementů [W3Schools XSD Indicators](https://w3schools.com/xml/schema_complex_indicators.asp). Dělíme je na indikátory:
1. Řádu – řídí pořadá elementů (all = libovolné pořadí, choice = exkluzivní výběr, sequence = přesně dané pořadí)
2. Výskytu – řídí počet elementů (maxOccurs = maximální počet elementů, minOccurs = minimální počet elementů)
3. Skupiny – řídí uspořádání prvků do pojmenovaných skupin

### Substituční skupiny

Další užitečným mechanismem je substituční mechanismus, který lze využít např.: pro vícejazyčné XML dokumenty. XSD umožňuje definovat skupinu zaměnitelných elementů (tzv. substituční skupina), ve které jsou elementy vzájemně zaměnitelné [W3Schools XSD Substitution](https://w3schools.com/xml/schema_complex_subst.asp).

### XSD Libovolné elementy

Pokud chceme ještě větší volnost a umožnit vložit uživateli v XML v nějaké části libovolné elementy, pak můžeme využít v XSD element <any> [W3Schools XSD Any](https://w3schools.com/xml/schema_complex_any.asp). Obdobný mechanismus existuje i pro atributy elementů pomocí <anyAttribute> [W3Schools XSD anyAttribute](https://w3schools.com/xml/schema_complex_anyattribute.asp).

### ❖ Úkol 2.2 – soubor `student.dtd`

Napište DTD validační soubory k entitě student z minulé hodiny. Pokud se vám nelíbí moje DTD k fakultě, tak si také vytvořte vlastní DTD pro fakultu.

Zde vidíte příklad DTD souboru, který slouží pro validaci barmanských receptů:

```
<!ELEMENT menu (recept+)>
<!ATTLIST menu xmlns:xsi CDATA #FIXED "http://www.w3.org/2001/XMLSchema-instance">
<!ATTLIST menu xsi:noNamespaceSchemaLocation CDATA #FIXED "menu.xsd">

<!ELEMENT recept (informace, ingredience, postup)>
<!ATTLIST recept
autor_článku CDATA #REQUIRED
hodnocení CDATA #FIXED "1"
počet_hodnotících CDATA #FIXED "0">

<!ELEMENT informace (název, země_původu?, doba_přípravy, obtížnost)>

<!ELEMENT název (#PCDATA)>

<!ELEMENT země_původu (#PCDATA)>

<!ELEMENT doba_přípravy (#PCDATA)>

<!ELEMENT obtížnost (začátečník|pokročilý|mistr)?>
<!ELEMENT začátečník EMPTY>
<!ELEMENT pokročilý EMPTY>
<!ELEMENT mistr EMPTY>

<!ELEMENT ingredience (položka+)>
<!ATTLIST ingredience počet_porcí CDATA "1">

<!ELEMENT položka (#PCDATA)>
<!ATTLIST položka
odkaz_koupě CDATA #IMPLIED
typ (základ|dochucovadlo|dekorace|nezařazené) "nezařazené">

<!ELEMENT postup (#PCDATA)>
```

A příklad XML souboru:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<menu>
    <!-- každá kniha obsahuje dva názvy a to český a anglický -- specifikováno atributem -->
    <název jazyk=cz>Epos o Berygamešovi
    <název jazyk=en>Epic of Berygamesh
    <Autor>Jiří Fišer</autor>
    <postavy><postava>Berygameš</postava><postava>Škvorkidu<postavy/></postava>
</kniha>
<kniha>
    <název jazyk=cz>Pán prstenů: návrat Fišera
    <název jazyk=en>Lord of the rings: return of Fišer
    <Autor>Beránek Pavel</autor>
    <popis>
        Kniha o partě ajťáků, kteří se chystají na výpravu na zápočet na Fakultu Osudu.
    </popis>
</kniha>
```

### ❖ Úkol 2.3 – Přepsání DTD souboru na XSD soubor

Ke svým DTD souborům vytvořte XSD soubory, které budou validovat stejné XML soubory. Jelikož XSD umí více než DTD, můžete rozšířit validační možnosti. Zaměřte se na to, ať máte XSD soubory přehledně strukturované.

Zde vidíte příklad mého XSD souboru, který slouží pro validace barmanských receptů:

```
<?xml version="1.0" encoding="UTF-8" ?>
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema">

    <!-- definition of simple elements -->
    <xs:element name="název" type="xs:string"/>
    <xs:element name="doba_přípravy" type="xs:positiveInteger"/>
    <xs:element name="obtížnost" type="xs:string"/>
    <xs:element name="země_původu" type="xs:string"/>
    <xs:element name="postup" type="xs:string"/>
    <xs:element name="obtížnost">
        <xs:complexType />
    </xs:element>

    <!-- definition of simple types -->
    <xs:simpleType name="položka_typ">
        <xs:restriction base="xs:string">
            <xs:enumeration value="základ"/>
            <xs:enumeration value="dochucovadlo"/>
            <xs:enumeration value="dekorace"/>
            <xs:enumeration value="nezařazené"/>
        </xs:restriction>
    </xs:simpleType>

    <!-- definition of attributes -->
    <xs:attribute name="autor_článku" type="xs:string"/>
    <xs:attribute name="hodnocení" type="xs:positiveInteger" fixed="1"/>
    <xs:attribute name="počet_hodnotících" type="xs:decimal" fixed="0"/>
    <xs:attribute name="počet_porcí" type="xs:positiveInteger" default="1"/>
    <xs:attribute name="odkaz_koupě" type="xs:string"/>
    <xs:attribute name="typ" type="položka_typ" default="nezařazené"/>

    <!-- definition of complex types -->
    <xs:element name="menu">
        <xs:complexType>
            <xs:sequence>
                <xs:element ref="recept" minOccurs="1" maxOccurs="unbounded"/>
            </xs:sequence>
        </xs:complexType>
    </xs:element>

    <xs:element name="recept">
        <xs:complexType>
            <xs:sequence>
                <xs:element ref="informace"/>
                <xs:element ref="ingredience"/>
                <xs:element ref="postup"/>
            </xs:sequence>
            <xs:attribute ref="autor_článku" use="required"/>
            <xs:attribute ref="hodnocení"/>
            <xs:attribute ref="počet_hodnotících"/>
        </xs:complexType>
    </xs:element>

    <xs:element name="informace">
        <xs:complexType>
            <xs:sequence>
                <xs:element ref="název"/>
                <xs:element ref="země_původu" minOccurs="0" maxOccurs="1"/>
                <xs:element ref="doba_přípravy" />
                <xs:element ref="obtížnost" minOccurs="0" maxOccurs="unbounded"/>
            </xs:sequence>
        </xs:complexType>
    </xs:element>

    <xs:element name="ingredience">
        <xs:complexType>
            <xs:sequence>
                <xs:element ref="položka" minOccurs="1" maxOccurs="unbounded"/>
            </xs:sequence>
            <xs:attribute ref="počet_porcí" default="1"/>
        </xs:complexType>
    </xs:element>

    <xs:element name="položka">
        <xs:complexType>
            <xs:simpleContent>
                <xs:extension base="xs:string">
                    <xs:attribute ref="odkaz_koupě"/>
                    <xs:attribute ref="typ"/>
                </xs:extension>
            </xs:simpleContent>
        </xs:complexType>
    </xs:element>

</xs:schema>
```

### ❖ Úkol 2.4 – Validace validního XML souboru XSD souborem

Upravte soubor `index.php` tak, aby validoval ne pomocí DTD schématu, ale pomocí XSD schématu:
* Není potřeba přidávat (inject) DTD data do XML.
* Validaci provedete pomocí volání funkce ```$doc->schemaValidate($xsdPath)```.

Pokuste se soubor `index.php` nejdříve sami upravit. Pokud narazíte na potíže, nahlédněte do přiloženého adresáře `Projekt 2/php/src`.
