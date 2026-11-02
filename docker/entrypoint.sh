#!/bin/sh
set -e

# Render tells us which port to listen on through $PORT
PORT="${PORT:-10000}"

sed -i "s/^Listen [0-9]*$/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

exec apache2-foreground
