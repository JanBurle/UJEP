# Fullstack Web Application

This is a fullstack web client/server application. It features a simple user authentication
system, a login page, home and other pages.

The server is built using Docker with Apache, PHP 8, and PostgreSQL.

The client is built using vanilla HTML, CSS, and JavaScript.

## Project Structure

```
├── .vscode/                # VSCode configuration
├── docker/                 # Docker configuration files
├── init-db/                # database initialization scripts
├── inc/                    # PHP include files (outside of web root)
├── www/                    # web files (web root)
│   ├── .htaccess           # apache configuration
│   ├── assets/             # static assets (images, fonts, etc.)
│   ├── css/                # styles
│   ├── js/                 # JavaScript files
│   ├── index.php           # main page
│   ├── login.php           # login page
│   ├── *.php               # other pages
│   └── ...
├── .editorconfig           # editor configuration
├── .prettierrc             # prettier configuration
├── bash*.sh                # opens a bash shell in a container
├── docker-compose.yml      # Docker multi-container configuration
└── README.md               # this file
```

## Setup

- Build and start the Docker multi-container:

  ```sh
  docker-compose up --build
  ```

- Access the web site in a browser at `http://localhost:8080`.
  - Log in with one of the default users (password `pwd`):
    - john@example.com
    - jane@example.com
    - alice@example.com

## Work in the containers

Open the `bash` shell in the containers:

- `bashws.sh`: in the web server container, as the `pri` user
- `bashws-root.sh`: in the web server container, as the `root` user.
- `bashwspg.sh`: in the PostgreSQL container, as the `postgres` user.
  - inside, connect to the database with `psql -U pri`.

## Debugging

- PHP in VSCode: "Listen for XDebug"
- DOM in the browser: DevTools, Elements tab
- CSS in the browser: DevTools, Styles tab
- JavaScript in the browser: DevTools, `debugger`, Console tab
- HTTP requests: DevTools, Network tab, also `curl -Lv localhost:8080`
