# Runs all four PHP projects in one container (Apache + PHP 8.2).
# Used by Render (free web service). Static projects are served by Vercel instead.
FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo_mysql \
    && a2enmod headers

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
COPY docker/index.php /var/www/html/index.php
COPY docker/health.php /var/www/html/health.php

COPY projects/employee-management /var/www/html/employee-management
COPY projects/contact-management  /var/www/html/contact-management
COPY projects/nexora-company      /var/www/html/nexora-company
COPY projects/department-portal   /var/www/html/department-portal

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && chown -R www-data:www-data /var/www/html

ENV PORT=10000
EXPOSE 10000

CMD ["/usr/local/bin/entrypoint.sh"]
