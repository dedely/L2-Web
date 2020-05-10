<?php
include "include/cookies.inc.php";
$title = "Prévisions météo";
session_start();
city_cookie();
option_cookie();
include "include/header.inc.php";
count_detailed_hits("weather");
?>

<section>
    <h2><?php echo getCityName() ?></h2>
    <?php
    echo "<div class=\"center\">";
    displayCityForm();
    echo "</div>\n";
    processCityForm();
    ?>
</section>

<?php require_once "include/footer.inc.php"; ?>