<?php
$title = "Weather";
session_start();
include "include/header.inc.php";
?>

<?php
displayCity();
displayCityForm();
?>


<?php require_once "include/footer.inc.php"; ?>