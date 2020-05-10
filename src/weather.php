<?php
$title = "Weather";
session_start();
include "include/header.inc.php";
?>

<?php
displayCity();
echo "<div class=\"center\">";
displayCityForm();
echo"</div>";
?>


<?php require_once "include/footer.inc.php"; ?>