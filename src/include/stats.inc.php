<?php
define("DPT_STATS_FILE", "../stats/dpt_stats.csv");
define("OPTION_STATS_FILE", "../stats/options.csv");

/**
 * This function reads dpt_stats.csv and returns data about the departments queries as an array
 * @author Adel
 * @return array
 */
function getDptData(): array
{
    $input = fopen(DPT_STATS_FILE, "r");
    $REGION_CODE = 0;
    $DPT_CODE = 1;
    $COUNT = 2;
    $dptData = array();
    //We call fgets once to skip the first line of our csv as it doesn't contain relevant information.
    fgets($input);
    while ((($data = fgetcsv($input, ",")) !== FALSE)) {
        $count = intval($data[$COUNT]);
        $cell = array();
        $cell["dpt"] = $data[$DPT_CODE];
        $cell["count"] = $count;
        $dptData[] = $cell;
    }
    fclose($input);
    return $dptData;
}
/**
 * This function reads dpt_stats.csv and returns data about the display options as an array
 * @author Adel
 * @return array
 */
function getOptionData(): array
{
    $input = fopen(OPTION_STATS_FILE, "r");
    $OPTION = 0;
    $COUNT = 1;
    $optionData = array();
    //We call fgets once to skip the first line of our csv as it doesn't contain relevant information.
    fgets($input);
    while ((($data = fgetcsv($input, ",")) !== FALSE)) {
        $count = intval($data[$COUNT]);
        //Ignore 0 values as they wouldn't be relevant in a pie chart.
        $cell = array();
        $cell["option"] = $data[$OPTION];
        $cell["count"] = $count;
        $optionData[] = $cell;
    }
    fclose($input);
    return $optionData;
}