<?php
$title = "Statistiques";
include "include/header.inc.php";
?>

<section>
    <h2>Statistiques générales</h2>
    <div class=center>
        <p>Nombre de hits : <?php echo count_hits() ?></p>
        <?php 
        echo "<img src=\"stats/dpt_chart.php\" alt=\"test\"/>";
        echo "<img src=\"stats/option_chart.php\" alt=\"test\"/>";
        ?>
    </div>
</section>

<?php require_once "include/footer.inc.php"; ?>