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
//dpm($node);
?>
<?php if($node->build_mode != NODE_BUILD_SEARCH_RESULT): ?>
<?php print $picture ?>

<?php if (!$page && $title): ?>
<h2 class="node-title"><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
<?php endif; ?>
<?php if ($submitted && 0):?>
<div class="submitted"><?php print $submitted ?></div>
<?php endif; ?>

<table id="video-node-content"
	class="clearfix"><tr>
<td id="video-node-content-left">

<?php
if(count($node->video_nodes) > 0) {
foreach($node->video_nodes as $vn) {
    print($vn->body);
}
}
else
{
    print '<img src="/sites/default/files/images/novideo.png">';
}
?></td>

<td id="video-node-content-right"><?php // show information 
print '<div id="show_info_block"><ul class="show-info-block-list">';
if ($node->project_nid && $node->project_title && $node->project_id) {
print '<li class="project_link"><a href="/projects/'. $node->project_nid.'" title="click to see all shows in this series">'. $node->project_title.'</a></li>';
}
//dpm($node);
if ($terms) {
print '<li class="taxonomy">'.$terms.'</li>';
}
print '<li><span class="label">Produced:</span> '.date('n/j/y',$node->event_date) ;
print ' <span class="label">by</span> '.$node->producer_name. '</li>';
print '<li><span class="label">Length:</span> '.(int)($node->trt / 60) . ' minutes</li>';
print '</ul></div>';
//$shows = $cablecast->getSchedule(0,array(1,2), 'now',0,6*24);
//  $shows = $ce->getSchedule($show_id,array(50,51), 'now',0,6*24);
print '<div id=show-broadcast-schedule>';
if(is_array($node->schedule_events) && count($node->schedule_events)>0) {

    $days = array();
    $channels_used = array();
    print '<h4 >Broadcast times this week:</h4><ul class="broadcast-times">';
    foreach($node->schedule_events as $day => $events) {
        $times_string = "";
        foreach($events as $index => $event) {
            if(is_array($event->taxonomy) && count($event->taxonomy)>0) {
                foreach($event->taxonomy as $event_taxon) {
                    if($event_taxon->vid == 4) {
                        $channel_tid = $event_taxon->tid;
                        $channel_name = $event_taxon->name;
                        break;
                    }
                }
            }
 //           dpm($event->start_time." ".date(_cablecast_extensions_fix_time($event->start_time))." ".date('g:iA', $event->start_time));
            $times_string .= ' <span class="channel_id_'.$channel_tid.'">'.(date('g:iA', $event->start_time))."</span>,";
        }
        $times_string = trim( $times_string  , ',' );
        $nextweek = $event->start_time > strtotime(date('m/d/Y',time()+7*24*60*60)) ? "Next " : "";
        print '<li class="video-show-times"><span class="date">'.$nextweek.date('l',strtotime($day)).':</span><span class="times">'.$times_string."</span></li>";
    }
    print '</ul>';
    print '<table id="channels_legend"><tr>';
    print '<td class="channel_id_'.$channel_tid.'">'.$channel_name.'</td>';
    print '</tr></table>';
}
else
{
    print '<div class="none">This program is not scheduled for broadcast in the next week</div>';
}
print '</td>';


?> 
</tr>
<!-- video-node-content-right --></table>
<?php if ($links):?>
<div class="node-links"><?php print $links; ?></div>
<?php endif; ?>
<?php else: // show search results ?>
<?php
$content = '<tr>';
                $content .= '<td class="show_link"><a href="/'.$node->path.'">'.t($node->title).'</a>'. '</td>'; 
                $content .='<td class="event_time">'.date('m/d/y',$node->event_date). '</td>';
                $content .= '<td class="vod_links">'.$node->vod_links. '</td>'; 
                $content .= '</tr>';
print $content;
?>
<?php endif; ?>
<!-- video-node-content -->
