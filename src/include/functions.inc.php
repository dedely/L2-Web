<?php

/**
 * Set to true/false to see/hide debug elements.
 */
define("DEBUG", false);

/*The following functions display the appropriate departments and cities forms using the naive approach of running through the entire csv files.*/

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


        echo "<form method=\"GET\" action=\"weather.php\">\n";
        echo "\t<fieldset>\n";
        echo "\t\t<legend>dpt dropdown</legend>\n";
        echo "\t\t<select name=\"dpt\" id=\"dpt\">\n";
        echo "\t\t\t<option value=\"none\" selected disabled hidden>Select a department</option>\n";

        for ($i = 0; $i < count($departments); $i++) {
            displayOption($departments[$i]);
        }

        echo "\t\t</select>\n";
        echo "\t\t\t<input type=\"submit\" value=\"Go!\"/>\n";
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
    $stop = false;
    $state = 0;
    while ((($data = fgetcsv($handle, 1000, ",")) !== FALSE) && !$stop) {
        if (($state == 0) && ($data[0] == $regionCode)) {
            $state = 1;
        }
        if ($state == 1) {
            if ($data[0] != $regionCode) {
                $state = 2;
            } else {
                $dpt["code"] = $data[1];
                $dpt["name"] = $data[2];
                $departments[] = $dpt;
            }
        }
        if ($state == 2) {
            $stop = true;
        }
    }
    fclose($handle);
    return $departments;
}

/**
 * This function displays a dropdown form of the cities in a given department.
 *
 * @return void
 */
function displayCityForm()
{
    if (isset($_GET["dpt"])) {

        $dptCode = $_GET["dpt"];
        if (DEBUG) {
            echo "<p>regionCode: " . $dptCode . "</p>\n";
        }
        $cities = getCities($dptCode);


        echo "<form method=\"GET\" action=\"weather.php\">\n";
        echo "\t<fieldset>\n";
        echo "\t\t<legend>City dropdown</legend>\n";
        echo "\t\t<select name=\"city\" id=\"city\">\n";
        echo "\t\t\t<option value=\"none\" selected disabled hidden>Select a city</option>\n";

        for ($i = 0; $i < count($cities); $i++) {
            displayOption($cities[$i]);
        }

        echo "\t\t</select>\n";
        echo "\t\t\t<input type=\"submit\" value=\"Go!\"/>\n";
        echo "\t</fieldset>\n";
        echo "</form>\n";
    }
}

/**
 * A simple utility method which uses a csv file to return the appropriate informations.
 *
 * @param string $dptCode
 * @return array $cities
 */
function getCities($dptCode)
{
    $citiesData = "./resources/cities.csv";
    $handle = fopen($citiesData, "r");
    //We call fgets once to skip the first line of our csv as it doesn't contain relevant information.
    fgets($handle);
    $cities = array();
    $stop = false;
    $state = 0;
    while ((($data = fgetcsv($handle, ",")) !== FALSE)&& !$stop) {
        if (($state == 0) && ($data[0] == $dptCode)) {
            $state = 1;
        }
        if ($state == 1) {
            if ($data[0] != $dptCode) {
                $state = 2;
            } else {
                $city["code"] = $data[2];
                $city["name"] = $data[3];
                $cities[] = $city;
            }
        }
        if ($state == 2) {
            $stop = true;
        }
    }
    fclose($handle);
    return $cities;
}

/**
 * test function
 *
 * @return void
 */
function processCityForm()
{
    if (isset($_GET["city"])) {
        $weatherData = queryWeatherAPI($_GET["city"]);
        displayWeather($weatherData);
    }
}

/**
 * This function sends a query to the openweathermap api using the provided zip code to get weather data as a json string.
 * NOTE: Atm, we don't take into consideration the possibility of a query failing. We'll add additionnal logic later.
 *
 * @param string $zip A city zip code.
 * @return array $weatherData An associative array with weather data.
 */
function queryWeatherAPI($zip)
{
    $url = "http://api.openweathermap.org/data/2.5/weather?zip=" . $zip . ",FR&appid=1f3d52717caedbf49c7f39dc59562336";
    $json = file_get_contents($url);
    if (DEBUG) {
        echo "<p>" . $json . "</p>\n";
    }
    $weatherData = json_decode($json, true);
    return $weatherData;
}


function displayWeather($weatherData)
{
    $option = "now";
    if (isset($_GET["option"])) {
        $option = $_GET["option"];
    }
    switch ($option) {
        case "now":
            displayCurrentWeatherData($weatherData);
            break;
        default:
            echo "<p>Unknown option!</p>\n";
            break;
    }
}


function displayCurrentWeatherData($weatherData)
{
    echo "<h2>" . $weatherData["name"] . "</h2>\n";
    $weather = $weatherData["weather"][0];
    echo "\t\t\t<figure>\n";
    echo "\t\t\t\t<img src=\"http://openweathermap.org/img/wn/" . $weather["icon"] . ".png \" alt=\"weather illustration\"/>\n";
    echo "\t\t\t</figure>\n";
    echo "\t\t\t<p>" . $weather["description"] . ", feels like: " . getTemp($weatherData["main"]) . "°C.</p>\n";
}

function getTemp($temp)
{
    $feelslike = $temp["feels_like"];
    $feelslike -= 273.15;
    return $feelslike;
}
