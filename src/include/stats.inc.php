<?php
define("DPT_STATS_FILE", "./stats/dpt_stats.csv");

function getDptData(): array{
    $input = fopen(DPT_STATS_FILE, "r");
    $REGION_CODE = 0;
    $DPT_CODE = 1;
    $COUNT = 2;
    $dptData = array();
    while ((($data = fgetcsv($input, ",")) !== FALSE)) {
            $count = intval($data[$COUNT]);
            //increment the counter value and replace the old value.
            $data[$COUNT] = ++$count;
            
    }
    fclose($input);
    return $dptData;
}