<?php
$title = "Weather forecast app";
include "include/header.inc.php";
?>

        <aside>
            <h3> Les nouveautés </h3>
            <p> Changement de la carte de la page principale </p>
            <p> Ajout de cartes pour choisir le département </p>
            <p> Ajout d'un aperçu de la région sur la page du choix du département </p>
            <p> Avancement de la page de statistiques </p>
        </aside>
        <section>
            <h2>Bienvenue!</h2>
            <h3>Sélectionnez votre région!</h3>
            <?php
                require "./maps/france.map";
            ?>
        </section>


<?php require_once "include/footer.inc.php"; ?>