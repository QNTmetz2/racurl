<?php
include('tools.php');
include('rb.phar');
R::setup('mysql:host=localhost;dbname=racurl','racurluser','racurlpwd');
R::debug (TRUE, 1);

if (false)//!isset($_SESSION['pseudo']))
  header('Location: index.php');
else {
  echo <<<STAT
  <!DOCTYPE html> 
  <html>
  <head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta charset="utf-8" />
  <title>Statistiques</title>

  <!--Load the AJAX API-->
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript">
  // Load the Visualization API and the piechart package.
  google.load('visualization', '1.0', {'packages':['corechart']});
   
  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(drawChart);
 
  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function drawChart() {
    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
STAT;
$pseudo='raoul';
$urls=array(100);//compteURL($pseudo));
$bind1 = array($pseudo);
$m = R::findOne('membres', 'pseudo = ?', $bind1);
$id = $m->id;
$bind2 = array($id);
$urls = R::findAll('urls', 'auteur = ?', $bind2);

foreach($urls as $value){
  $bind3=array($value->id);
  $usages=R::count('utilisations','url = ?',$bind3);
  echo "['".$value->source."',".$usages."],";
}
echo "])";
echo <<<AFFICHE
// Set chart options
var options = {'title':'Statistique d\'utilisation de vos URL','width':800,'height':600};
// Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
  </script>
  </head>
  <body>
  <div><a href='index.php'>Retour</a></div>
  <div>
  <!--Div that will hold the pie chart-->
  <div id="chart_div"></div>
  </div>
AFFICHE;
  finHTML();
}
?>
