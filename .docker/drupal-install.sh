#!/bin/bash -e
set -e
DRUSH=/app/src/vendor/bin/drush
DRUPAL=/app/src/vendor/bin/drupal

echo "Installing Drupal"
$DRUSH -y site:install minimal --account-pass=teamagile6 --sites-subdir=default --db-url=mysql://dbuser:dbpass@db:3306/drupal --config-dir=/app/src/config/sync

echo "Importing Configuration"
$DRUSH -y config-import

echo "Adding Administrator role and user"
$DRUSH user:role:add administrator va.gov-modernization

echo "Adding Publisher role and user"
$DRUSH user:role:add publisher Chris.Publisher

echo "Adding Content Creator role and user"
$DRUSH user:role:add content_creator Mary.Creator

echo "Adding Reviewer role and user"
$DRUSH user:role:add editor Mei.Editor

echo "Unblocking and setting e-mail addresses for demo users"
$DRUSH sqlq "UPDATE users_field_data SET mail=CONCAT(name, '@example.com'), status=1 WHERE uid > 0"

echo "Setting passwords"
for NAME in $($DRUSH sqlq "SELECT name FROM users_field_data WHERE uid > 0"); do
  $DRUSH user:password "${NAME}" "teamagile6"
done

echo "Rebuilding node access"
$DRUPAL --root=/app/src/docroot node:access:rebuild

echo "Rebuilding cache"
$DRUSH cache:rebuild
