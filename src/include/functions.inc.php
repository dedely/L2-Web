<?php

/**
 * Set to true/false to see/hide debug elements.
 */
define("DEBUG", false);

/*The following functions display the appropriate departments and cities forms using the naive approach of running through the entire csv files. */

/**
 * This function displays a dropdown form of the departments in a region using the regionCode in the $_GET superglobal array.
 * 
 * @return void
 */
function displayDptForm()
{
    if (isset($_GET["regionCode"])) {
        $regionCode = $_GET["regionCode"];
        if (DEBUG) {
            echo "<p>regionCode: " . $regionCode . "</p>\n";
        }
        $departments = getDepartments($regionCode);


        echo "<form method=\"GET\" action=\"dpt.php\">\n";
        echo "\t<fieldset>\n";
        echo "\t\t<legend>dpt dropdown</legend>\n";
        echo "\t\t<select name=\"dpt\" id=\"dpt\">\n";
        echo "\t\t\t<option value=\"none\" selected disabled hidden>Select a department</option>\n";

        for ($i = 0; $i < count($departments); $i++) {
            displayOption($departments[$i]);
        }

        echo "\t\t\t<input type=\"submit\" value=\"Go!\"/>\n";
        echo "\t\t</select>\n";
        echo "\t</fieldset>\n";
        echo "</form>\n";
    }
}

/**
 *We're going to display options for the dpt and the cities forms, so might as well make it a function ;)
 * @param array $arr
 * @return void
 */
function displayOption($arr)
{
    echo "\t\t\t<option value=\"" . $arr["code"] . "\">" . $arr["name"] . "</option>\n";
}

/**
 * A simple utility method which uses a csv file to return the appropriate informations.
 *
 * @param string $regionCode
 * @return array $departments
 */
function getDepartments($regionCode = "11")
{
    $dptData = "./resources/departments.csv";
    $handle = fopen($dptData, "r");
    //We call fgets once to skip the first line of our csv as it doesn't contain relevant information.
    fgets($handle);
    $departments = array();
    while ((($data = fgetcsv($handle, 1000, ",")) !== FALSE)) {
        if ($data[1] == $regionCode) {
            $dpt["code"] = $data[2];
            $dpt["name"] = $data[3];
            $departments[] = $dpt;
        }
    }
    return $departments;
}

/**
 * test function
 *
 * @return void
 */
function processDptForm(){
    if (isset($_GET["dpt"])){
        echo "<p>dptCode: " . $_GET["dpt"] . "</p>\n";
    }
}