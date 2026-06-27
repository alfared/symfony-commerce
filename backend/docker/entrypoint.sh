#!/bin/sh
set -e

if [ "$RUN_MIGRATIONS" = "1" ]; then
  php bin/console doctrine:migrations:migrate --no-interaction
fi

exec apache2-foreground