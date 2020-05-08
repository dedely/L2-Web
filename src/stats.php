<?php
$title = "Statistiques";
include "include/stats.inc.php";
include "include/header.inc.php";
?>

<section>
    <h2>Statistiques générales</h2>
    <div class=center>
        <p>Nombre de hits : <?php echo count_hits() ?></p>
    </div>
</section>

<?php require_once "include/footer.inc.php"; ?>