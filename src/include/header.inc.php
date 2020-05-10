<?php
    include "include/functions.inc.php";
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title><?php echo $title ?></title>
        <meta name="author" content="Adel Abbas, Kevin Bernard" />
        <meta name="date" content=<?php echo "\"" . date('D, d M Y') . "\"" ?> />
        <meta name="keywords" content="Weather forecast, Region, City, CY, <?php echo $title ?>" />
        <meta name="description" content="" />
        <meta charset="utf-8" />
        <link rel="stylesheet" href="./standard.css" />
    </head>

    <body>
        <header>
           <div class="container">
                <img class="maximized" src="./images/clouds.jpg" alt="Clouds"/>
                <div class="centered">
                    <h1>Météo</h1>
                </div>
            </div>
            <nav>
                <ul id="nav">
                    <li><a href="./index.php">Accueil</a></li>
                    <?php
                        if (isset($_SERVER['PHP_SELF']))
                        {
                            $currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME);
                            if($currentPage == "weather.php")
                            {
                                if (isset($_GET["dpt"]))
                                {
                                    $dptCode=$_GET["dpt"];
                                    $regionCode=getRegionCode($dptCode);
                                    echo"<li><a href=\"./dpt.php?region=$regionCode\">Départements</a></li>";
                                }
                            }
                        }
                    ?>
                    <li><a href="./comingsoon.php">Statistiques</a></li>
                </ul>
            </nav>
        </header>
        