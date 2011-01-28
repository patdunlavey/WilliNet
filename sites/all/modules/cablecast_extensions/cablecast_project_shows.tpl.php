<?php
//dpm($node);
$output = "<div class=\"cablecast-project-shows\">\n".
$limit = variable_get('cablecast_project_shows_per_page',NULL);

$shows_table_header = array(array('data'=>t("Show"),'class'=>''), array('data'=>t("Date"),'class'=>''), array('data'=>t("Length"),'class'=>''), array('data'=>t("View Online"),'class'=>'vod_links'));
$shows_table_rows = array();
foreach($node->cablecast_shows as $show)  {
    $vodlinks = $show->node->vod_links ? $show->node->vod_links : '';
    $shows_table_rows[] = array(
    array('data'=> '<a href="/'.$show->node->path.'">'.check_markup($show->node->title).'</a>', 'class'=>'show_title'),
    array('data'=> date('m/d/Y',$show->node->event_date), 'class'=>'event_date'),
    array('data'=> (int)($show->node->trt/60) . ' min', 'class'=>'event_trt'),
    array('data'=> $vodlinks, 'class'=>'vod_links')
    );  
}
$output .= theme_table($shows_table_header, $shows_table_rows, array('id'=>'cablecast_project_shows', 'class' => 'cablecast_project_shows'));
$output .= theme('pager',array(), $limit);
$output .= "\n</div><!-- cablecast-project-shows-->";
print $output;