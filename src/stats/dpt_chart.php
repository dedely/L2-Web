<?php
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

//$pieplot->SetSliceColors(array('#1E90FF','#2E8B57','#ADFF2F','#DC143C','#BA55D3'));
$graph->Stroke();

?>