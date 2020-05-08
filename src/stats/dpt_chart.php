<?php
/**
 * The following file is heavily inspired by the jpgraph simple pie plot example.
 * It can be found at https://jpgraph.net/features/src/show-example.php?target=new_pie1.php
 */
include "../include/stats.inc.php";
require_once ('../jpgraph/jpgraph.php');
require_once ('../jpgraph/jpgraph_pie.php');

// Organise data
$tmp = getDptData();
$data = array();
$legends = array();
foreach ($tmp as $key => $value) {
    $data[] = $value["count"];
    $legends[] = $value["dpt"];
}

// Create the Pie Graph. 
$graph = new PieGraph(350,250);

$theme_class="DefaultTheme";
//$graph->SetTheme(new $theme_class());

// Set A title for the plot
$graph->title->Set("Départements les plus consultés");
$graph->SetBox(true);

// Create
$pieplot = new PiePlot($data);
$graph->Add($pieplot);

$pieplot->ShowBorder();
$pieplot->SetColor('black');
$pieplot->SetLegends($legends);

$graph->Stroke();

?>