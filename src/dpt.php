<?php
    $title = "Dpt form";
    include "include/header.inc.php";
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