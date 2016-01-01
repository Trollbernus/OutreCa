L'Outre-Ça
==========

Requirement
-----------

Install [less with node via npm](https://www.npmjs.com/package/less).

Run
```sh
HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
```

```sh
php app/check.php
```
and fix the mandatory requirements.
You may have to restart the server.
```sh
/etc/init.d/apache2 restart
```

Configuration
-------------

Create your **app/config/parameters.yml** form **app/config/parameters.yml.dist** or click [here](http://127.0.0.1:8000/config.php) after running
```sh
php app/console server:run
```

Installation
------------

Install vendors via [composer](https://getcomposer.org/download/)

```sh
composer install
```

Install [yui_compressor_2.4.8](https://github.com/yui/yuicompressor/releases) and [closure-compiler](https://github.com/google/closure-compiler) at **app/Resources/java/**

```sh
php app/console mopa:bootstrap:install:font
```

Delete the mopabootstrap sass file.

Dump and install the assets.
```sh
php app/console assetic:dump
php app/console assets:install
```

Generate the database.
```sh
php app/console doctrine:database:create
php app/console doctrine:schema:create
```

To finish, [register](http://127.0.0.1:8000/register) to the blog and promote your account with ROLE_AUTHOR and ROLE_ADMIN.

```sh
php app/console fos:user:promote $username$
```

Uploads
-------

Create the folder 'web/uploads'.
