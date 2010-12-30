<?php
// $Id$

/**
 * @file
 * Administrative page callbacks for the cablecast module
 */
 
 /**
  * Form builder. Configure
  */
  function cablecast_admin_settings() {
    
    $form['cablecast_server_url'] = array(
      '#type' => 'textfield',
      '#title' => t('CableCast server url'),
      '#attributes' => array('class' => ''),
      '#default_value' => variable_get('cablecast_server_url',NULL),
      '#description' => t('Enter the URL for your CableCast server, including the trailing backslash, e.g. <code>http://137.165.204.126/</code>'),
    );
    return system_settings_form($form);
  }