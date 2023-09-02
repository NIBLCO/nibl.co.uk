#!/bin/bash

composer update
composer install
npm install
composer format
composer psalm
npm run prod
