<?php
include "include/cookies.inc.php";
$title = "Prévisions météo";
session_start();
city_cookie();
option_cookie();
include "include/header.inc.php";
?>

<section>
    <h2><?php echo getCityName() ?></h2>
    <?php
    displayCityForm();
    processCityForm();
    ?>
</section>

<?php require_once "include/footer.inc.php"; ?>