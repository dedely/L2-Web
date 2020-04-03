<?php
    $title = "Weather";
    include "include/header.inc.php";
?>

        <h1>Weather forecast</h1>
        <section>
            <?php
                displayCityForm();
                processCityForm();
            ?>
        </section>

<?php require_once "include/footer.inc.php"; ?>