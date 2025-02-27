# Fullstack Web Application

This is a fullstack web client/server application. It features a simple user authentication
system with a login page and a home page.

The server is built using Docker with Apache, PHP 8, and PostgreSQL/MySQL.

The client is built using vanilla HTML, CSS, and JavaScript.

## Project Structure

```
├── www/                    # web files (client)
│   ├── .htaccess           # apache configuration
│   ├── css/                # styles
│   │   ├── main.css
│   │   └── ...
│   ├── js/                 # scripts
│   │   └── scripts.js
│   ├── index.php           # main page
│   ├── login.php           # other pages
│   ├── inc/                # php include files
│   └── ...
├── server                  # server files
│   ├── docker-compose.yml  # Docker multi-container
│   ├── db                  # database container files
│   │   └── init.sql
│   ├── web                 # web server container files
│   │   └── Dockerfile
│   └── ...
├── .editorconfig           # for a consistent indentation
└── README.md               # this file
```

## Setup

- Build and start the Docker multi-container:

  ```sh
  cd server
  docker-compose up --build
  ```

- Access the application in a browser at `http://localhost:8000`.

## Usage

- _Login_: Enter the email and password to log in.
- _Home Page_: After logging in, you will be redirected to the home page.
- _Logout_: You can log out to return to the login page.

## Default Users

There are these default users in the database:

- john@example.com
- jane@example.com
- alice@example.com

All have the password `pwd`.

## Debugging

- PHP in VSCode: PHP Debug
- DOM in the browser: DevTools, Elements tab
- CSS in the browser: DevTools, Styles tab
- JavaScript in the browser: DevTools, `debugger`, Console tab
- HTTP requests: DevTools, Network tab, also `curl -Lv localhost:8000`
