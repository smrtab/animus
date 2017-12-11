#!/bin/sh
cd /animus/server
php bin/console doctrine:migrations:migrate
exec "$@"