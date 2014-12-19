My Meta Maps
============

## Introduction
My Meta Maps is a web-app to rate and comment geo data. 

This project was developed by students of B.Sc. Geoinformatics of the Institute for geoinformatics at the WWU Münster. 
+ C. Rendel
+ C. Rohtermundt
+ M. Mohr
+ M. Rieping
+ M. Köster

To use or test our web-app visit: http://giv-geosoft2b.uni-muenster.de/ (only inside of WWU Münster network)

For development or other code related tasks simply clone or fork the my-meta-maps repository.

## Used technologies / libraries (extract)
### Server
+ [PHP](http://php.net/)
+ [PostgreSQL](http://www.postgresql.org/) + [PostGIS](http://www.postgis.net/)
+ [Laravel](http://laravel.com/)
+ [IMP - INSPIRE Metadata Parser](http://www.webmapcenter.de/imp/webseite/)
+ [EasyRDF](http://www.easyrdf.org/)
+ [php-mf2](https://github.com/indieweb/php-mf2)
+ [GeoPHP](https://geophp.net/)

### Client
+ [Bootstrap](http://getbootstrap.com/)
+ [jQuery](http://jquery.com/)
+ [Backbone.js](http://backbonejs.org/)
+ [Underscore.js](http://underscorejs.org/)
+ [OpenLayers](http://openlayers.org/)

## License
Copyright 2014 C. Rendel, C. Rohtermundt, M. Mohr, M. Rieping, M. Köster

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at http://www.apache.org/licenses/LICENSE-2.0.

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.

## Installation

### Prepare server
1. Install [Apache HTTPD](http://httpd.apache.org) 2.2 (or newer) with [mod_rewrite](http://httpd.apache.org/docs/current/mod/mod_rewrite.html) extension
2. Install [PostgreSQL](http://www.postgresql.org) 9.1 (or newer)
3. Install [PostGIS](http://postgis.net) 2.0 (or newer)
4. Install [PHP](http://php.net) 5.4 (or newer)
5. Install [Composer](https://getcomposer.org/)

### Set up My Meta Maps
1. Download the files from this repository and upload them to the root folder of your web server.
2. Run `composer install` (cmd line) in the root directory of your web server to install all project dependencies.
3. Create a new PostgreSQL database with UTF8 encoding using the SQL command `CREATE DATABASE project ENCODING 'UTF8';` or any PostgreSQL database administration tool.
4. Enable PostGIS extension on your new database using the SQL command `CREATE EXTENSION postgis;`.
5. Run `php artisan migrate` (cmd line) in root directory of your web server to create the needed database tables.
6. Open `app/config/production/database.php` and change the database settings to fit your PostgreSQL installation.
7. Open `app/config/app.php` and change the settings (url, timezone, key, locale) according to your project environment.
8. You are done! Visit your web server and My Meta Maps should be shown in your browser.
