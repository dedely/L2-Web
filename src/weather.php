<?php
    $title = "Weather";
    include "include/header.inc.php";
?>

        <h1>Weather</h1>
        <section>
            <h2>Results</h2>
            <?php
                displayCityForm();
                processCityForm();
            ?>
        </section>

<?php require_once "include/footer.inc.php"; ?>