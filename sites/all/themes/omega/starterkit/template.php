<?php
// $Id: template.php,v 1.1.2.9 2010/07/09 14:53:42 himerus Exp $

/*
 * Add any conditional stylesheets you will need for this sub-theme.
 *
 * To add stylesheets that ALWAYS need to be included, you should add them to
 * your .info file instead. Only use this section if you are including
 * stylesheets based on certain conditions.
 */
/* -- Delete this line if you want to use and modify this code
 // Example: optionally add a fixed width CSS file.
 if (theme_get_setting('omega_starterkit_fixed')) {
 drupal_add_css(path_to_theme() . '/layout-fixed.css', 'theme', 'all');
 }
 // */


/**
 * Implementation of HOOK_theme().
 */
function omega_starterkit_theme(&$existing, $type, $theme, $path) {
    $hooks = omega_theme($existing, $type, $theme, $path);
    // Add your theme hooks like this:
    /*
    $hooks['hook_name_here'] = array( // Details go here );
    */
    // @TODO: Needs detailed comments. Patches welcome!
    return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function
 function omega_starterkit_preprocess(&$vars, $hook) {
 $vars['sample_variable'] = t('Lorem ipsum.');
 }
 // */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* -- Delete this line if you want to use this function
 function omega_starterkit_preprocess_page(&$vars, $hook) {
 $vars['sample_variable'] = t('Lorem ipsum.');
 }
 // */

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function omega_starterkit_preprocess_node(&$vars, $hook) {
    // set up cablecast schedule event data
    if ($vars['node']->type == "cablecast_schedule_event") {
        $vars['node']->show_node = node_load($vars['node']->cablecast_show_nid);
        $vars['node']->video_nodes = array();
        $result = db_query("SELECT nid FROM {content_type_video} WHERE field_show_id_value = '%d' order by field_show_id_value asc",$vars['node']->showID);
        while ($row = db_fetch_object($result)) {
            $vars['node']->video_nodes[] = node_load($row->nid);
        }
    }
    elseif ($vars['node']->type == "cablecast_show") {
        $vars['node'] = cablecast_extensions_show_node_load($vars['node']->nid, $vars['node']->build_mode);
        $vars['node']->schedule_events = array();
        $date = time();
        $week = 60*60*24*7;
        $result = db_query("SELECT nid FROM {cablecast_schedule_event} WHERE showID = '%d' and start_time <= %d and end_time >= %d order by start_time asc",$vars['node']->showID, $date+$week, $date);
        while ($row = db_fetch_object($result)) {
            $this_node = node_load($row->nid);
            $vars['node']->schedule_events[date('m/d/Y',$this_node->start_time)][] = $this_node;
        }
 
        $vars['node']->body = $vars['body'];
        $vars['node']->video_nodes = array();
        $result = db_query("SELECT nid FROM {content_type_video} WHERE field_show_id_value = '%d' order by field_show_id_value asc",$vars['node']->showID);
        while ($row = db_fetch_object($result)) {
            $vars['node']->video_nodes[] = node_load($row->nid);
        }
        foreach($vars['node']->taxonomy as $taxon) {
            $vars['node']->category = $taxon->name;
            break;
        }
//        dpm($vars['node']);
//             dpm($vars);
    }
    
    //  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
 function omega_starterkit_preprocess_comment(&$vars, $hook) {
 $vars['sample_variable'] = t('Lorem ipsum.');
 }
 // */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
 function omega_starterkit_preprocess_block(&$vars, $hook) {
 $vars['sample_variable'] = t('Lorem ipsum.');
 }
 // */


/**
 * Create a string of attributes form a provided array.
 *
 * @param $attributes
 * @return string
 */
function omega_starterkit_render_attributes($attributes) {
    return omega_render_attributes($attributes);
}

function omega_starterkit_pager($tags = array(), $limit = 10, $element = 0, $parameters = array(), $quantity = 9){
    global $pager_page_array, $pager_total, $pager_total_items;
   if($pager_total[0]) {
    $page = $pager_page_array[0] + 1;
    $first_no = $limit * $pager_page_array[0] + 1;
    $last_no = ($limit * $page) > $pager_total_items[0] ? $pager_total_items[0] : $limit * $page;
    $next_no = $pager_total_items[0] - ($page * $limit) > $limit ? $limit : $pager_total_items[0] - ($page * $limit);
    $previous_no = $limit;
    $li_text = 'Showing '.$first_no.'-'.$last_no.' of '. $pager_total_items[0];
    $li_previous = theme('pager_previous', t('< previous @no',array('@no'=>$previous_no)), $limit, $element, 1, $parameters);
    $li_next = theme('pager_next', t('next @no >',array('@no'=>$next_no)), $limit, $element, 1, $parameters);
    
    if ($li_previous) {
    $items[] = array(
      'class' => 'pager-previous',
      'data' => $li_previous,
    );
  }
  if ($li_text) {
    $items[] = array(
      'class' => 'pager-text',
      'data' => $li_text,
    );
  }
   
  if ($li_next) {
    $items[] = array(
      'class' => 'pager-next',
      'data' => $li_next,
    );
  }

  return theme('item_list', $items, NULL, 'ul', array('class' => 'pager'));
   }
 
}

function omega_starterkit_menu_item_link($link) {
  if (empty($link['localized_options'])) {
    $link['localized_options'] = array();
  }
  $result= l($link['title'], $link['href'], $link['localized_options']);
  $result = str_replace('">', '"><span>', $result);
  $result = str_replace("</a>", "</span></a>", $result);
  return '<span>'.$result.'</span>';
  }

