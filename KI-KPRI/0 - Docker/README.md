# Vývojové prostředí (Docker)

Jako pracovní vývojové prostředí použijeme Docker kontejner (virtuální Linux) + VSCode (IDE).

Z repozitáře [KI-KPRI](../) si stáhněte [pracovní projekt](../Projekt%20-%20pracovní).

## Docker kontejner: [LAMP](https://en.wikipedia.org/wiki/LAMP_(software_bundle))  (Linux – Apache – MySQL – PHP)

[Docker](https://www.docker.com/) je softwarový nástroj („virtualizační platforma“), která umožňuje vytvářet tzv. docker obrazy (*images*) a spouštět je v docker kontejnerech (*containers*). Obraz si lze představit jako read-only momentku (*snapshot*) virtualizovaného počítače s operačním systémem, na kterém jsou nainstalovány potřebné programy.

Obraz je typicky založen na minimální spustitelné verzi operačního systému. To je tzv. základ (*base*) docker obrazu. Potřebný obraz je pak sestaven tak, že do základu se pomocí skriptu, uloženým v textovém souboru *Dockerfile*, doinstalují další potřebné utility a programy.

Z docker obrazů lze pak spouštět nezávislé docker kontejnery, to jest běžící virtualizované počítače, které transparentně využívají služby hostitelského (*host*) operačního systému.

*Docker Compose* propojí několik kontejnerů do jedné běžící aplikace.

## Pracovní projekt: pracovní složky/adresáře a soubory

Projekt má tuto strukturu:
```bash
├── compose.yaml                # definice multi-kontejneru
├── docker-prune.sh             # zastaví a smaže Docker objekty
├── Dockerfiles
|   ├── PhpApache               # virtuální Linux s Apache a PHP
|   ├── Database                # MySQL kontejner
|   └── univerzita.sql
└── www                         # odpovídá /var/www serveru
     ├── html                   # kořen webových stránek (Apache)
     |   ├── *.php              # PHP soubory = jednotlivé webové stránky
     |   └── ...
     └── xml                    # XML soubory, nejsou přímo přístupné z Apache
         ├── *.xml
         ├── *.xsd
         ├── *.xsl
         └── ...
```


### Jednotlivé soubory
* [compose.yaml](/Projekt%207/compose.yaml)
* []()
```Dockerfile
# základní Docker obraz s PHP a Apache
FROM php:8-apache

# aktualizace systému
RUN apt update && apt upgrade -y

# instalace rozšíření pro XSL procesor
RUN apt install -y libxslt1-dev
RUN docker-php-ext-install xsl

# instalace rozšíření mysqli pro komunikaci s mysql databází
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# úklid dále nepotřebných souborů
RUN apt remove -y libxslt1-dev icu-devtools libicu-dev libxml2-dev
RUN rm -rf /var/lib/apt/lists/*
```
*Dockerfile* je soubor, který slouží Dockeru pro vytvoření obrazu. Uvedený Dockerfile provede následující:
* Stáhne základní obraz Linuxové distribuce s nainstalovaným jazykem PHP a Apache serverem.
* Nainstaluje aktualizace systému, které proběhly po vytvoření základního obrazu.
* Nainstaluje rozšíření PHP s XSL procesorem (který není součástí standardní distribuce PHP).
* Nainstaluje PHP rozšíření (driver) [myslqi](https://www.php.net/manual/en/book.mysqli.php) pro připojení PHP k MySQL databázi.

Základní obraz [php:8-apache](https://hub.docker.com/_/php) je minimální Linuxová distribuce Debian, s nainstalovaným interpretrem PHP a webovým serverem Apache ([httpd](https://en.wikipedia.org/wiki/Httpd)).

#### `compose.yaml`
```YAML
services:
  # PHP a Apache, popsáno v Dockerfile
  php-apache:
    container_name: php-apache
    build:
      context: ./php              # zde se nalézá Dockerfile
      dockerfile: Dockerfile
    depends_on:
      - db
    volumes:
      - ./php/src:/var/www/html/  # mapování vnější/vnitřní složky
    ports:
      - 8000:80                   # mapování vnějšího/vnitřního portu Apache

  # instalace databáze MySQL
  db:
    container_name: db
    image: mysql                  # základní obraz
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: db
      MYSQL_USER: admin
      MYSQL_PASSWORD: heslo
    ports:
      - 9906:3306                 # mapování vnějšího/vnitřního portu MySQL

  # instalace phpmyadmin pro správu databází
  phpmyadmin:
    image: phpmyadmin/phpmyadmin  # základní obraz
    ports:
      - 8080:80                   # port 80 bude zveřejněn jako 8080
    restart: always
    environment:
      PMA_HOST: db
    depends_on:
      - db
```

