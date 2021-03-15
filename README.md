# DramaSoc Casting Bot

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## Table of Contents

* [Installation with Sail](#Installation%20with%20Sail)
* [Installation without Laravel Sail](#Installation%20without%20Laravel%20Sail)
* [Usage](#Usage)
* [Authors](#Authors)
* [Copyright](#Copyright%20and%20License)

---

## Installation with Sail

Before starting the install, you should make sure you have both git, docker and docker compose installed.

- https://git-scm.com/book/en/v2/Getting-Started-Installing-Git
- https://docs.docker.com/get-docker/
- https://docs.docker.com/compose/install/

``` bash
# clone the repo
$ git clone https://github.com/dramabarn/DramaSoc-Casting-Bot.git my-project

# go into app's directory
$ cd my-project

# install app's dependencies
$ composer install
```

Copy file ".env.example", and change its name to ".env".

```bash
# Start up sail
$ ./vendor/bin/sail up -d
```

This will start up the docker container with the needed databases and php server! You may wish to configure
a [bash alias](https://laravel.com/docs/8.x/sail#configuring-a-bash-alias) so you don't need to enter
```./vendor/bin/sail``` everytime instead you can use ```sail``` when setup.

### Next steps

``` bash
# generate laravel APP_KEY
$ ./vendor/bin/sail artisan key:generate

# run database migration and seed
$ ./vendor/bin/sail artisan migrate:refresh --seed

# generate mixing
$ ./vendor/bin/sail npm run dev

# and repeat everytime js files are changed to generate mixing
$ ./vendor/bin/sail npm run dev
```

If no .env settings are changed the site will be hosted
on [http://casting-bot.test:8000/](http://casting-bot.test:8000/)

Click "Login" on sidebar menu and log in with credentials:

* E-mail: _admin@admin.com_
* Password: _password_

This user has roles: _user_ and _admin_

### Taking down the server

``` bash
$ ./vendor/bin/sail sail down
```

More infomation on Laravel Sail is in the [Sail Docs](https://laravel.com/docs/8.x/sail)

---

## Installation without Laravel Sail

``` bash
# clone the repo
$ git clone https://github.com/dramabarn/DramaSoc-Casting-Bot.git my-project

# go into app's directory
$ cd my-project

# install app's dependencies
$ composer install

# install app's dependencies
$ npm install

```

### Database Setup

#### SQLite

``` bash
# create database
$ touch database/database.sqlite
```

Copy file ".env.example", and change its name to ".env". Then in file ".env" replace this database configuration:

* DB_CONNECTION=mysql
* DB_HOST=127.0.0.1
* DB_PORT=3306
* DB_DATABASE=laravel
* DB_USERNAME=root
* DB_PASSWORD=

To this:

* DB_CONNECTION=sqlite
* DB_DATABASE=/path_to_your_project/database/database.sqlite

#### PostgreSQL

1. Install PostgreSQL

2. Create user

``` bash
$ sudo -u postgres createuser --interactive
enter name of role to add: laravel
shall the new role be a superuser (y/n) n
shall the new role be allowed to create database (y/n) n
shall the new role be allowed to create more new roles (y/n) n
```

3. Set user password

``` bash
$ sudo -u postgres psql
postgres= ALTER USER laravel WITH ENCRYPTED PASSWORD 'password';
postgres= \q
```

4. Create database

``` bash
$ sudo -u postgres createdb laravel
```

5. Copy file ".env.example", and change its name to ".env". Then in file ".env" replace this database configuration:

* DB_CONNECTION=mysql
* DB_HOST=127.0.0.1
* DB_PORT=3306
* DB_DATABASE=laravel
* DB_USERNAME=root
* DB_PASSWORD=

To this:

* DB_CONNECTION=pgsql
* DB_HOST=127.0.0.1
* DB_PORT=5432
* DB_DATABASE=laravel
* DB_USERNAME=laravel
* DB_PASSWORD=password

#### MySQL

Copy file ".env.example", and change its name to ".env". Then in file ".env" complete this database configuration:

* DB_CONNECTION=mysql
* DB_HOST=127.0.0.1
* DB_PORT=3306
* DB_DATABASE=laravel
* DB_USERNAME=root
* DB_PASSWORD=

### Set APP_URL

If your project url looks like
``` example.com/sub-folder```
Then go to `my-project/.env`
And modify the line:

* `APP_URL = `

To make it look like this:

* `APP_URL = http://example.com/sub-folder`

### Next step

``` bash
# in your app directory
# generate laravel APP_KEY
$ php artisan key:generate

# run database migration and seed
$ php artisan migrate:refresh --seed

# generate mixing
$ npm run dev

# and repeat generate mixing
$ npm run dev
```

---

## Usage

``` bash
# start local server
$ php artisan serve
```

Open your browser with address: [localhost:8000](localhost:8000)  
Click "Login" on sidebar menu and log in with credentials:

* E-mail: _admin@admin.com_
* Password: _password_

This user has roles: _user_ and _admin_

---

## Authors

**Nathan Billis**

**John Cherry**

## Acknowledgments

Based on 'CastingBot V2' by **Jon Derrick** and the original by **Stephen Hutt**

Interface based on [Core UI](https://coreui.io/)

## Copyright and License

Copyright 2020 York DramaSoc. CORE UI Code released
under [the MIT license](https://github.com/coreui/coreui-free-laravel-admin-template/blob/master/LICENSE).

