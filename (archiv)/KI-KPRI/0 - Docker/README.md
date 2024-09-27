# Vývojové prostředí (Docker)

Jako pracovní vývojové prostředí použijeme Docker kontejner (virtuální Linux) + VSCode (IDE).

## Pracovní projekt (příklady)

Stáhněte si [pracovní projekt](../Projekt%20-%20work).

## Docker kontejner: [LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle))  (Linux – Apache – MySQL – PHP)

[Docker](https://www.docker.com/) je softwarový nástroj („virtualizační platforma“), která umožňuje vytvářet tzv. docker obrazy (*images*) a spouštět je v docker kontejnerech (*containers*). Obraz si lze představit jako read-only momentku (*snapshot*) virtualizovaného počítače s operačním systémem, na kterém jsou nainstalovány potřebné programy.

Obraz je typicky založen na minimální spustitelné verzi operačního systému. To je tzv. základ (*base*) docker obrazu. Potřebný obraz je pak sestaven tak, že do základu se pomocí skriptu, uloženým v textovém souboru *Dockerfile*, doinstalují další potřebné utility a programy.

Z docker obrazů lze pak spouštět nezávislé docker kontejnery, to jest běžící virtualizované počítače, které transparentně využívají služby hostitelského (*host*) operačního systému.

*Docker Compose* propojí několik kontejnerů do jedné běžící aplikace.

## Pracovní projekt: pracovní složky/adresáře a soubory

Projekt má tuto strukturu:
```bash
├── compose.yaml                # definice multi-kontejneru
├── Dockerfiles                 # soubory pro Docker
│   ├── PhpApache               # virtuální Linux s Apache a PHP
│   ├── Database                # MySQL kontejner
│   └── univerzita.sql          # SQL skript pro inicializaci databáze
└── www                         # odpovídá /var/www serveru
     ├── html                   # kořen webových stránek (v dosahu Apache)
     │   ├── .htaccess          # konfigurace Apache
     │   ├── *.php              # PHP soubory = jednotlivé webové stránky
     │   └── ...                # atd.
     ├── include
     │   └── ...                # PHP include soubory
     └── xml-side               # XML soubory mimo dosah Apache
         └── ...
```

### Jednotlivé soubory

#### `compose.yaml`

Nástroj *Docker Compose* propojí několik Docker obrazů do jednoho spolupracujícího celku a spustí tzv. multikontejnerovou aplikaci.

Konfigurace naší aplikace je popsána v souboru <tt>compose.yaml</tt>, podle kterého Docker Compose:
1. Sestaví obraz z *Dockerfile* PhpApache, propojí ho s databázovým obrazem, a nastaví vnější port webového serveru na 8000. Dále mapuje vnitřní adresář Apache serveru, ve kterém jsou data pro webovou stránku a jiné, na náš vnější adresář.
2. Stáhne databázový obraz [mysql](https://hub.docker.com/_/mysql) z *Docker Hub* repositáře, namapuje port databáze na vnější port 9906, nastaví root heslo, vytvoří uživatele *admin* a nastaví mu heslo, a inicializuje databázi.
3. Stáhne docker obraz [adminer](https://hub.docker.com/_/adminer/) z *Docker Hub*, a nastaví jeho vnější port na 8080.

#### `Dockerfiles/PhpApache`

  Stáhne základní obraz Linuxové distribuce s nainstalovaným jazykem PHP a Apache serverem. Nainstaluje aktualizace systému, které proběhly po vytvoření základního obrazu. Nainstaluje rozšíření PHP s XSL procesorem (který není součástí standardní distribuce PHP). Nainstaluje PHP rozšíření (driver) [myslqi](https://www.php.net/manual/en/book.mysqli.php) pro připojení PHP k MySQL databázi. Nainstaluje pomocné programy.

  Základní obraz [php:8-apache](https://hub.docker.com/_/php) je minimální Linuxová distribuce Debian, s nainstalovaným interpretrem PHP a webovým serverem Apache ([httpd](https://en.wikipedia.org/wiki/Httpd)).

#### `Dockerfiles/Database`

Stáhne základní obraz s MySQL a inicializuje databázi ze SQL skriptu.

#### `www/html/.htaccess`

V kořenovém adresáři `www/html` je soubor [.htaccess](https://httpd.apache.org/docs/current/howto/htaccess.html) ve kterém je povoleno, aby Apache generoval obsah adresáře. Nemusíme tak mít soubor `index.php` (nebo `index.html`).

### Docker v příkazové řádce

Celou sestavu spustíme pomocí [příkazu v terminálu](https://docs.docker.com/engine/reference/commandline/compose_up/):
```bash
docker compose up
```
*Docker Compose* sestaví obrazy a spustí podle nich kombinaci kontejnerů. Pokud vše proběhne správně, bude naše webová aplikace přístupná v prohlížeči na URL [http://localhost:8000](http://localhost:8000) a administrace databáze na [http://localhost:8080](http://localhost:8080).

Pro připojení terminálu k běžícímu kontejneru:
```bash
docker ps                         # vypíše běžící kontejnery
docker exec -ti CONTAINER_ID bash # v kontejneru spustí interaktivní shell
```

Pokud máte `bash` jako shell, můžete použít následující skript pro zastavení běžících kontejnerů a vymazání všech kontejnerů, obrazů a disků v Dockeru:

```bash
docker stop $(docker ps -q)
docker rm $(docker ps -aq)
docker rmi $(docker images -q)
docker volume prune -f
```