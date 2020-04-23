<?php

/**
 * Set to true/false to see/hide debug elements.
 */
define("DEBUG", false);

/**
 * The api key provided by openweathermap.org
 */
define("API_KEY", "1f3d52717caedbf49c7f39dc59562336");

/**
 * The language code we using when calling the openweathermap api.
 */
define("LANG", "fr");
define("UNITS", "metric");

define("SEPARATOR", "&amp;");

define("HOURLY", "hourly");
define("DAILY", "daily");

date_default_timezone_set('Europe/Paris');
/*The following functions display the appropriate departments and cities forms using a sequential search algorithm through csv files.*/

/**
 * This function displays a dropdown form of the departments in a region using the regionCode in the $_GET superglobal array.
 * 
 * @return void
 */
function displayDptForm()
{
    if (isset($_GET["region"])) {
        $regionCode = $_GET["region"];
        if (DEBUG) {
            echo "<p>regionCode: " . $regionCode . "</p>\n";
        }
        $departments = getDepartments($regionCode);


        echo "<form method=\"GET\" action=\"weather.php\">\n";
        echo "\t<fieldset>\n";
        echo "\t\t<legend>dpt dropdown</legend>\n";
        echo "\t\t<select name=\"dpt\" id=\"dpt\">\n";
        echo "\t\t\t<option value=\"none\" selected disabled hidden>Sélectionner un département</option>\n";

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
 * The csv file is sorted by regionCode.
 *
 * @param string $regionCode
 * @return array $departments
 */
function getDepartments($regionCode = "11")
{
    $dptData = "./resources/departments.csv";
    $handle = fopen($dptData, "r");

    //Change the following variables if changes are made in the csv file.
    $REGION_CODE = 0;
    $DPT_CODE = 1;
    $DPT_NAME = 2;

    //We call fgets once to skip the first line of our csv as it doesn't contain relevant information.
    fgets($handle);
    $departments = array();
    $stop = false;
    $state = 0;
    while ((($data = fgetcsv($handle, 1000, ",")) !== FALSE) && !$stop) {
        if (($state == 0) && ($data[$REGION_CODE] == $regionCode)) {
            $state = 1;
        }
        if ($state == 1) {
            //We stop once we found all the information about a given dpt.
            if ($data[$REGION_CODE] != $regionCode) {
                $stop = true;
            } else {
                $dpt["code"] = $data[$DPT_CODE];
                $dpt["name"] = $data[$DPT_NAME];
                $departments[] = $dpt;
            }
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
        echo "\t\t\t<option value=\"none\" selected disabled hidden>Sélectionnez une ville</option>\n";

        for ($i = 0; $i < count($cities); $i++) {
            $city = $cities[$i];
            $encodedValue  = http_build_query($city, "", SEPARATOR);
            echo "\t\t\t<option value=\"" . $encodedValue . "\">" . $city["name"] . "</option>\n";
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

    //Change the following variables if changes are made in the csv file.
    $DPT_CODE = 0;
    $INSEE_CODE = 1;
    $ZIP_CODE = 2;
    $CITY_NAME = 3;
    $GPS_LAT = 4;
    $GPS_LNG = 5;

    //We call fgets once to skip the first line of our csv as it doesn't contain relevant information.
    fgets($handle);
    $cities = array();
    $stop = false;
    $state = 0;
    while ((($data = fgetcsv($handle, ",")) !== FALSE) && !$stop) {
        if (($state == 0) && ($data[$DPT_CODE] == $dptCode)) {
            $state = 1;
        }
        if ($state == 1) {
            if ($data[$DPT_CODE] != $dptCode) {
                $stop = true;
            } else {
                $city["code"] = $data[$ZIP_CODE];
                $city["name"] = $data[$CITY_NAME];
                $city["lat"] = $data[$GPS_LAT];
                $city["long"] = $data[$GPS_LNG];
                //Add the city element to the $cities array.
                $cities[] = $city;
            }
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
    //empty($_GET["dpt"]) && 
    if (empty($_GET["dpt"]) && isset($_GET["city"])) {
        $encodedValue = $_GET["city"];
        parse_str($encodedValue, $city);
        unset( $_SESSION["city"]);
        $_SESSION["city"] = $city;
        if (isset($city["lat"], $city["long"])) {
            $weatherData = queryWeatherAPIGPS($city["lat"], $city["long"]);
            unset($_SESSION["weather"]);
            $_SESSION["weather"] = $weatherData;
            displayWeather();
        }
    }elseif (empty($_GET["dpt"]) && isset($_SESSION["weather"])){
        displayWeather();
    }
}

function displayOptions()
{
    if (isset($_SESSION["weather"])) {
        echo "<form method=\"GET\" action=\"weather.php\">\n";
        echo "\t<fieldset>\n";
        echo "\t\t<legend>Options</legend>\n";
        echo "\t\t<label for=\"hourly\">Par heure</label>\n";
        echo "\t\t<input type=\"radio\" name=\"option\" value=\"hourly\" id=\"hourrly\" size=\"10\"/>\n";
        echo "\t\t<label for=\"daily\">Par jour</label>\n";
        echo "\t\t<input type=\"radio\" name=\"option\" value=\"daily\" id=\"daily\" size=\"10\"/>\n";
        echo "\t\t<input type=\"submit\" value=\"Go!\"/>\n";
        echo "\t</fieldset>\n";
        echo "</form>\n";
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
    $url = "http://api.openweathermap.org/data/2.5/weather?zip=" . $zip . ",FR&appid=" . API_KEY;
    $json = file_get_contents($url);
    if (DEBUG) {
        echo "<p>" . $url . "</p>\n";
        echo "<p>" . $json . "</p>\n";
    }
    $weatherData = json_decode($json, true);
    return $weatherData;
}

/**
 * This function sends a query to the openweathermap one call api using the provided gps information to get weather data as a json string.
 *
 * @param string $lat
 * @param string $long
 * @return array $weatherData An associative array with weather data.
 */
function queryWeatherAPIGPS($lat, $long)
{
    $url = "https://api.openweathermap.org/data/2.5/onecall?lat=" . $lat . "&lon=" . $long . "&appid=" . API_KEY . "&lang=" . LANG . "&units=" . UNITS;
    $json = file_get_contents($url);
    if (DEBUG) {
        echo "<p>" . $url . "</p>\n";
        echo "<p>" . $json . "</p>\n";
    }
    $weatherData = json_decode($json, true);
    return $weatherData;
}

function displayWeather($option = HOURLY)
{
    if (isset($_GET["option"])) {
        $option = $_GET["option"];
    }
    displayOptions();
    if (isset($_SESSION["weather"])) {
        switch ($option) {
            case HOURLY:
                displayHourlyForecasts();
                break;
            case DAILY:
                displayDailyForecasts();
                break;
            default:
                # code...
                break;
        }
    }
}

function displayHourlyForecasts()
{
    $forecasts = $_SESSION["weather"]["hourly"];

    echo "<table>\n";
    echo "\t<thead>\n";
    echo "\t<tr>\n";
    echo "\t\t<th>Heure</th>\n";
    echo "\t\t<th>Description</th>\n";
    echo "\t\t<th>Température</th>\n";
    echo "\t</tr>\n";
    echo "\t</thead>\n";
    echo "\t<tbody>\n";

    foreach ($forecasts as $key => $forecast) {
        displayHourlyForecast($forecast);
    }

    echo "\t</tbody>\n";
    echo "</table>\n";
}

function displayHourlyForecast($forecast)
{

    $time = convertTime($forecast["dt"]);
    $temp = $forecast["temp"];
    $weather = $forecast["weather"][0];
    $description = $weather["description"];
    $icon = $weather["icon"];

    echo "\t<tr>\n";
    echo "\t\t<td>" . $time . "</td>\n";
    echo ("\t\t<td>" . displayWeatherIllustration($icon) . " " . $description . "</td>\n");
    echo ("\t\t<td>" . $temp . " °C</td>\n");
    echo "\t</tr>\n";
}

function convertTime($dt)
{
    return date("H \h i", $dt);
}

function displayWeatherIllustration($icon)
{
    return "<img src=\"http://openweathermap.org/img/wn/" . $icon . ".png \" alt=\"weather illustration\"/>\n";
}

function getRegionName()
{
    if (isset($_GET["region"])) {
        $regionData = "./resources/regions.csv";
        $regionCode = $_GET["region"];
        $handle = fopen($regionData, "r");

        //Change the following variables if changes are made in the csv file.
        $REGION_CODE = 0;
        $REGION_NAME = 1;

        //We call fgets once to skip the first line of our csv as it doesn't contain relevant information.
        fgets($handle);
        $stop = false;
        $name = null;
        while ((($data = fgetcsv($handle, ",")) !== FALSE) && !$stop) {
            if ($data[$REGION_CODE] == $regionCode) {
                $name = $data[$REGION_NAME];
                $stop = true;
            }
        }
        fclose($handle);
        return $name;
    }
}

function displayCity(){
    require_once ("include/city.inc.php");
}

function getCityName(){
    $name = null;
    if(empty($_GET["dpt"]) && isset($_SESSION["city"])){
        $name = $_SESSION["city"]["name"];
    }
    if(empty($_GET["dpt"]) && isset($_GET["city"])){
        parse_str($_GET["city"], $city);
        $name = $city["name"];
    }
    if ($name == null){
        $name = "Prévisions par ville";
    }
    return $name;
}

function displayDailyForecasts(){
    $forecasts = $_SESSION["weather"]["daily"];

    echo "<table>\n";
    echo "\t<thead>\n";
    echo "\t<tr>\n";
    echo "\t\t<th>Jour</th>\n";
    echo "\t\t<th>Description</th>\n";
    echo "\t\t<th>Température</th>\n";
    echo "\t</tr>\n";
    echo "\t</thead>\n";
    echo "\t<tbody>\n";

    foreach ($forecasts as $key => $forecast) {
        displayDailyForecast($forecast);
    }

    echo "\t</tbody>\n";
    echo "</table>\n";
}

function displayDailyForecast($forecast){
    $time = getDay($forecast["dt"]);
    $temp = $forecast["temp"]["day"];
    $weather = $forecast["weather"][0];
    $description = $weather["description"];
    $icon = $weather["icon"];

    echo "\t<tr>\n";
    echo "\t\t<td>" . $time . "</td>\n";
    echo ("\t\t<td>" . displayWeatherIllustration($icon) . " " . $description . "</td>\n");
    echo ("\t\t<td>" . $temp . " °C</td>\n");
    echo "\t</tr>\n";
}

function getDay($dt){
    $frDays = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
    $date = getdate($dt);
    $wday = $date["wday"];
    return $frDays[$wday];
}