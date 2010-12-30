<?php
if (class_exists("CableCast")) {
    $cablecast = new CableCast();
}

?>

<div>
<?php
if(isset($cablecast->client)) {
$shows = $cablecast->GetLiveMeetingSchedule(120);

//dpm($shows);
  echo '<ul class="schedule">';
  foreach($shows as $show) {
    $phptime = strtotime($show->StartTime);
    $beginningTime = date("l, F jS, g:iA",$phptime);
    $href = '/show/'.$show->ShowID;
//print_r($show);
    echo '<li class="'.$show->tense.'">';
    echo $show->tense == 'present' ? '<h4 class="now-showing-notice">Now showing</h4>':'';
    echo '<ul class="show channel_'.$show->ChannelID.'">';
    echo '<li class="first channel channel_'.$show->ChannelID.'" alt="'.$show->ChannelName.'"><span>'.$show->ChannelName.'</span></li>';
    echo '<li class="time">'.$beginningTime.'</li>';
    echo '<li class="title last"><a href="'.$href.'" title="click to see more show times">'.$show->ShowTitle.'</a></li>';
    echo '</ul></li>';
  }
  echo '</ul>';
}
else {
print 'Sorry, cannot get program schedule information from Cablecast server';
}

?>
</div>