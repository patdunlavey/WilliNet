<?php
//$ $Id: cablecast_extensions.admin.inc,v 1.1 2010/07/20 22:18:47 patdunlavey Exp $

/**
 * @file
 * Administration page callbacks for the cablecast_extensions module.
 */

/**
 * Form builder.  Configure Cablecast Server
 *
 * @ingroup forms
 * @see system_setings_from().
 */
function cablecast_extensions_admin_settings() {
    $form['cablecast_server_username'] = array(
        '#type' =>  'textfield',
        '#title'    =>  t('Username'),
        '#default_value'    =>  variable_get('cablecast_server_username', NULL),
        '#size' =>  '60',
        '#description'  =>  t("Username for user with Cablecast admin permissions"),
        '#maxlength'    =>  '65',
        );
    $form['cablecast_server_password'] = array(
        '#type' =>  'password',
        '#title'    =>  t('Password'),
        '#default_value'    =>  variable_get('cablecast_server_password', NULL),
        '#size' =>  '20',
        '#description'  =>  t("Your Cablecast password"),
        '#maxlength'    =>  '65',
        );
    return system_settings_form($form);
}