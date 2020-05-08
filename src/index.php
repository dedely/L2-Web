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

        <section>
            <h2>Nouveautés</h2>
            <ul>
                <li>Ajout des cartes de région cliquables</li>
                <li>Suppression des doublons dans la liste déroulante des villes (filtre php, donc sans modifier le csv)</li>
                <li>Ajout des cookies pour la dernière ville consultée</li>
                <li>Ajout des cookies de préférence pour l'affichage des résultats</li>
                <li>Ajout d'un compteur de hits et ébauche de la page de statistiques.</li>
                <li>Ajout de l'affichage de la population</li>
            </ul>
        </section>


<?php require_once "include/footer.inc.php"; ?>