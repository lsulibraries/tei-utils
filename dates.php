<?php

$dates_raw = file_get_contents('/tmp/dates.csv');

$dates = explode("\n", $dates_raw);

$formatted = array();

foreach($dates as $date){
    $ftime = strftime('%B %e, %Y', strtotime($date));
    $formatted[] = $ftime;
}

file_put_contents('dates.tsv', implode("\n", $formatted));

?>