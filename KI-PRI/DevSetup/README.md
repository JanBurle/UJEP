## Vývojové prostředí

Pro vývoj budeme standardně používat virtualizační software [Docker](https://en.wikipedia.org/wiki/Docker_(software)) a editor zdrojového kódu [VS Code](https://en.wikipedia.org/wiki/Visual_Studio_Code). Vývojové prostředí tak bude mít každý stejné (téměř), nezávisle na operačním systému.

---
### Docker

Nainstalujte si [Docker Desktop](https://docs.docker.com/engine/install/). Tento balíček obsahuje všechny potřebné části softwaru: *Docker Engine* a *Docker Compose*.

---
### Visual Studio Code (VSCode)
Nainstalujte si [VSCode](https://code.visualstudio.com/). Můžete používat i jiný editor zdrojového kódu, nicméně VS Code je dnes de facto standard, a je tedy praktické se jej naučit používat. Existuje i komunitní verze [VSCodium](https://vscodium.com/).

#### Doporučená nastavení VSCode:
* *Files: Auto Save / onWindowChange* – usnadní vám práci: změněné texty se budou ukládat automaticky při přepnutí do jiného okna.
* *Files: Trim Trailing Whitespace* – při ukládání souboru se odstraní neviditelné mezery na konci řádků.

#### Doporučená rozšíření:
* PHP Tools for Visual Studio Code – formátování, nápověda, a další užitečné funkce při psaní PHP kódu.
* XML Tools for Visual Studio Code – podobně pro XML kód.

---
### shell
Pokud používáte Linux nebo MacOS, pak váš operační systém již obsahuje rozumný [shell](https://en.wikipedia.org/wiki/Shell_(computing)) (typicky [bash](https://en.wikipedia.org/wiki/Bash_(Unix_shell))) v terminálu. Pokud pracujete na Windows, doporučuji nainstalovat [Cygwin](https://cygwin.com/) nebo alespoň [Git BASH](https://gitforwindows.org/).