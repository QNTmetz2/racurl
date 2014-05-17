<?php

session_start();

function enteteHTML($titre)
{
  echo <<< YOP
  <!DOCTYPE html> 
  <html>
  <head>
  <script type="text/javascript" src="./scripts/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="./scripts/alphabet.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta charset="utf-8" />
  <title>$titre</title>
  </head>
  <body>
  <canvas id="myCanvas"></canvas>
  <script type="text/javascript" src="./scripts/bubbles.js"></script>
  <script type="text/javascript" src="./scripts/main.js"></script>
YOP;
}

function enteteTitreHTML($titre)
{
  enteteHTML($titre);
  echo <<< YOP

    <h1>
      $titre
    </h1>
YOP;
}

function titreHTML($titre)
{
  echo <<< YOP

    <h1>
      $titre
    </h1>
YOP;
}

function finHTML()
{
  echo <<< YOP

  </body>
</html>
YOP;
}

?>
