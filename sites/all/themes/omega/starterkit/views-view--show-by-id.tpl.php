<?php
// $Id: views-view.tpl.php,v 1.12.2.3 2010/03/25 20:25:23 merlinofchaos Exp $
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */
?>
<div id="video-node-content"
	class="clearfix"><?php 
	$show_id = arg(1);
	if(( ! is_numeric($show_id)) || $show_id < 1) {
	  print "<!--No show information available (missing Show ID)-->";
	}
	else
	{

	  $ce = new cablecast_extensions();
	    $show_info = $ce->getShowInformation($show_id);
//	    dpm($show_info);
	    print '<h2 class="node-title">'.$show_info['internalTitle'] . '</h2>';
	}
	?>

<div id="video-node-content-left">

<div class="<?php print $classes; ?>"><?php if ($admin_links): ?>
<div class="views-admin-links views-hide"><?php print $admin_links; ?></div>
<?php endif; ?> <?php if ($header): ?>
<div class="view-header"><?php print $header; ?></div>
<?php endif; ?> <?php if ($exposed): ?>
<div class="view-filters"><?php print $exposed; ?></div>
<?php endif; ?> <?php if ($attachment_before): ?>
<div class="attachment attachment-before"><?php print $attachment_before; ?>
</div>
<?php endif; ?> <?php if ($rows): ?>
<div class="view-content"><?php print $rows; ?></div>
<?php elseif ($empty): ?>
<div class="view-empty"><?php print $empty; ?></div>
<?php endif; ?> <?php if ($pager): ?> <?php print $pager; ?> <?php endif; ?>

<?php if ($attachment_after): ?>
<div class="attachment attachment-after"><?php print $attachment_after; ?>
</div>
<?php endif; ?> <?php if ($more): ?> <?php print $more; ?> <?php endif; ?>

<?php if ($footer): ?>
<div class="view-footer"><?php print $footer; ?></div>
<?php endif; ?> <?php if ($feed_icon): ?>
<div class="feed-icon"><?php print $feed_icon; ?></div>
<?php endif; ?></div>
<?php /* class view */ ?></div>

<div id="video-node-content-right"><?php // show information 
if( isset($show_info)) {

  //   	dpm($show_info->GetShowInformationResult);
  print '<div id="show_info_block"><ul class="show-info-block-list">';
  print '<li><!--<span class="label">Category:</span> -->'.$show_info['category_id'] . '</li>';
  print '<li><span class="label">Produced:</span> '.date('n/j/y',$show_info['event_date']) ;
  print ' <span class="label">by</span> '.$show_info['producer_name']. '</li>';
  print '<li><span class="label">Length:</span> '.(int)($show_info['trt'] / 60) . ' minutes</li>';
  print '</ul></div>';
  //$shows = $cablecast->getSchedule(0,array(1,2), 'now',0,6*24);
  $shows = $ce->getSchedule($show_id,array(50,51), 'now',0,6*24);
  print '<div id=show-broadcast-schedule>';
  if(is_array($shows) && count($shows)>0) {

    $days = array();
    $channels_used = array();
    foreach($shows as $broadcast) {
      $days[date('l, F jS',$broadcast->StartTime)][] = $broadcast;
      $channels_used[$broadcast->ChannelID] = 1;
    }

    print '<h4 >Broadcast times this week:</h4><ul class="broadcast-times">';
    foreach($days as $day => $times) {
      $times_string = "";
      foreach($times as $showtime) {
        $times_string .= ' <span class="channel_id_'.$showtime->ChannelID.'">'.(date('g:iA', $showtime->StartTime))."</span>,";
      }
      $times_string = trim( $times_string  , ',' );
      print '<li class="video-show-times"><span class="date">'.($day.':</span><span class="times">'.$times_string)."</span></li>";
    }
    print '</ul>';
    print '<table id="channels_legend"><tr>';
    print '<td class="channel_id_'.$showtime->ChannelID.'">'.$broadcast->ChannelName.'</td>';
    print '</tr></table>';
  }
  else
  {
    print 'This program is not scheduled for broadcast in the next week';
  }
  print '</div>';
   
}
else {
  print 'Unable to get program information from Cablecast server';
}

?></div>
<!-- video-node-content-right --></div>
<!-- video-node-content -->
