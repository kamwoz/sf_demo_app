### Instalation

Go to app/config, copy parameters.yml.dist to parameters.yml.
Remember create your database first.

Run `composer install`

Then update your schema

`php bin/console d:s:u --force`

Sometimes there are issue with permissions, its system related and fix is described in symfony docs

App run
=========

``php bin/console server:run`` (make sure that address is present in ng app in `config/parameters.js`)