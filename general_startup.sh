#!/bin/sh
# A set of general modules to start any Drupal dev project
drush dl admin
drush dl admin_menu
drush dl module_filter
drush dl views
drush dl cck
drush dl devel
drush dl devel_themer
drush dl token
drush dl pathauto
drush enable admin -q
drush enable admin_menu -q
drush enable module_filter -q
drush enable views -q
drush enable cck -q
drush enable devel -q
drush enable devel_themer -q
drush enable token -q
drush enable pathauto -q
