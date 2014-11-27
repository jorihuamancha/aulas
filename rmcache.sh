#!/bin/sh
chmod 777 /var/www * -R
rm /var/www/aulas/app/cache/dev/* -r
rm /var/www/aulas/app/cache/prod/* -r

