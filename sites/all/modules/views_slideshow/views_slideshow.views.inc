<?php
// $Id: views_slideshow.views.inc,v 1.1.2.1.2.1.2.1 2010/04/20 22:04:17 redndahead Exp $

/**
 * @file
 * Defines the View Style Plugins for Views Slideshow module.
 */

/**
 * Implements hook_views_plugins().
 */
function views_slideshow_views_plugins() {
  return array(
    'style' => array(
      'slideshow' => array(
        'title' => t('Slideshow'),
        'help' => t('Display the results as a slideshow.'),
        'handler' => 'views_slideshow_plugin_style_slideshow',
        'uses options' => TRUE,
        'uses row plugin' => TRUE,
        'uses_grouping' => FALSE,
        'type' => 'normal',
        'parent' => 'list',
        'path' => drupal_get_path('module', 'views_slideshow'),
        'theme' => 'views_slideshow',
        'theme path' => drupal_get_path('module', 'views_slideshow'),
        'theme file' => 'views_slideshow.theme.inc',
      ),
    ),
  );
}
