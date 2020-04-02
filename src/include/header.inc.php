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
        <link rel="stylesheet" href="standard.css" />
    </head>

    <body>
        <nav>
            <ul>
                <li class="homebutton"><a href="index.php">Home</a></li>
                <li><a href="comingsoon.php">Stats</a></li>
            </ul>
        </nav>
        