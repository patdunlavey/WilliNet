<?php
// $Id: node.tpl.php,v 1.1.2.3 2010/06/14 13:38:05 himerus Exp $

/**
 * @file node.tpl.php
 *
 * Theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: Node body or teaser depending on $teaser flag.
 * - $picture: The authors picture of the node output from
 *   theme_user_picture().
 * - $date: Formatted creation date (use $created to reformat with
 *   format_date()).
 * - $links: Themed links like "Read more", "Add new comment", etc. output
 *   from theme_links().
 * - $name: Themed username of node author output from theme_user().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $submitted: themed submission information output from
 *   theme_node_submitted().
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $teaser: Flag for the teaser state.
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 */
?>
<div<?php print $attributes; ?>>

  <?php print $picture ?>

  <?php if (!$page && $title): ?>
  <h2 class="node-title"><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
  <?php endif; ?>
  <?php if ($submitted):?>
  <div class="submitted"><?php print $submitted ?></div>
  <?php endif; ?>
  
  <div id="video-node-content" class="clearfix">
  <div id="video-node-content-left">
    <?php print $content ?>
    </div>

     <div id="video-node-content-right">
    <?php // show information 
    $show_id = $node->field_show_id[0]['value'];
    if(( ! is_numeric($show_id)) || $show_id < 1) {
    	print "<!--No show information available (missing Show ID)-->";
    }
    elseif( ! class_exists("CableCast")) {
      print "<!--CableCast server module not installed-->";
    }
    else
    {
      
      $cablecast = new CableCast();
      if($cablecast->client) {
    	$show_info = $cablecast->client->GetShowInformation(array('ShowID'=>$show_id));
      print '<div id="show_info_block"><ul class="show-info-block-list">';
      print '<li><!--<span class="label">Category:</span> -->'.$show_info->GetShowInformationResult->Category . '</li>';
      print '<li><span class="label">Produced:</span> '.date('n/j/y',strtotime($show_info->GetShowInformationResult->EventDate)) ;
      print ' <span class="label">by</span> '.$show_info->GetShowInformationResult->Producer. '</li>';
      print '<li><span class="label">Length:</span> '.(int)($show_info->GetShowInformationResult->TotalSeconds / 60) . ' minutes</li>';
      print '</ul></div>';
     $cablecast = new CableCast();
    //$shows = $cablecast->getSchedule(0,array(1,2), 'now',0,6*24);  
    $shows = $cablecast->getSchedule($show_id,array(1,2), 'now',0,6*24);  
	if(is_array($shows) && count($shows)>0) {

		$days = array();
		$channels_used = array();
		foreach($shows as $broadcast) {
		$days[date('l, F jS',strtotime($broadcast->StartTime))][] = $broadcast;
		$channels_used[$broadcast->ChannelID] = 1;
		}
		
		print '<h4 >Broadcast times this week:</h4><ul class="broadcast-times">';
		foreach($days as $day => $times) {
		$times_string = "";
		foreach($times as $showtime) {
		$times_string .= ' <span class="channel_id_'.$showtime->ChannelID.'">'.(date('g:iA', strtotime($showtime->StartTime)))."</span>,";
		}
		$times_string = trim( $times_string  , ',' );
		print '<li class="video-show-times"><span class="date">'.($day.':</span><span class="times">'.$times_string)."</span></li>";
		}
		print '</ul>';
		print '<table id="channels_legend"><tr>';
		if(isset($channels_used[1])) { print '<td class="channel_id_1">Channel 16</td>'; }
		if(isset($channels_used[2])) { print '<td class="channel_id_2">Channel 17</td>'; }
		print '</tr></table>';
	  }
      else
      {
        print 'This program is not scheduled for broadcast in the next week';
      }
      }
      else {
        print 'Unable to get program information from Cablecast server';
      }
    }
    ?>
</div> <!-- video-node-content-right -->
</div> <!-- video-node-content -->

  <?php if ($terms):?>
  <div class="taxonomy"><?php print $terms; ?></div>
  <?php endif; ?>
  <?php if ($links):?>
  <div class="node-links"><?php print $links; ?></div>
  <?php endif; ?>
  </div> <!-- does this fix or break??? -->
