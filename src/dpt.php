<?php
    $title = "Région";
    include "include/header.inc.php";
    count_detailed_hits("dpt");
?>
        <section>
            <h2><?php echo getRegionName() ?></h2>
            <?php
                echo "<div class=\"center\">";
                    displayDptForm();
                echo "</div>";
                displayDptMap();
            ?>
        </section>

<?php require_once "include/footer.inc.php"; ?>