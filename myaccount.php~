<?php
include('tools.php');
require 'rb.phar';
R::setup('mysql:host=localhost;dbname=racurl','racurluser','racurlpwd');
R::debug (TRUE, 1);
?>

<?php

function compteURL($pseudo) {
	$bind1 = array($pseudo);
	$m = R::findOne('membres', 'pseudo = ?', $bind1);
	$id = $m->id;
	$bind2 = array($id);
	$nb = R::count('urls', 'auteur = ?', $bind2);
	return $nb;
}

function afficheURLs($pseudo) {
	$bind1 = array($pseudo);
	$m = R::findOne('membres', 'pseudo = ?', $bind1);
	$id = $m->id;
	$bind2 = array($id);
	$urls = R::findAll('urls', 'auteur = ?', $bind2);
	echo "<form name='input' action='delownurls.php' method='post'>";
	echo '<table class="large">';
	echo "<tr><th colspan='4'>" . "URLs de " . $pseudo . "</th></tr>";
	echo '<tr><th>Source</th><th>Courte</th><th>Création</th><th>Suppression</th></tr>';
	$i = 0;
	foreach ($urls as $u) {
		$source = $u->source;
		$courte = $u->courte;
		$creation = $u->creation;
		echo '<tr bgcolor="#' . (($i++ % 2) ? "D0FFFF" : "FFD0FF") . '">';
                $cible=substr_replace($_SERVER['PHP_SELF'], "/acc.php?url=".$courte, -14);
		echo <<<CELL
		<td><a href=$source>$source</a></td>
		<td><a href=$cible>$courte</a></td>
		<td>$creation</td>
		<td>
		<input type="checkbox" name="todelete[]" value="$courte"><br>
		</td>
		</tr>
CELL;
	}
	echo "<tr><td></td><td></td><td></td><td><input type='submit' value='Supprimer'></td></tr>";
	echo '</table>';	
	echo '</form>';
}

function lienArriere() {
	echo "<a href='index.php'>Retour</a>";
}

if (!isset($_SESSION['pseudo']))
    header('Location: index.php');
else {
	$pseudo = $_SESSION['pseudo'];
	enteteTitreHTML('Mes URLs');
	if (compteURL($pseudo) == 0) {
		echo "Pas d'URL créée pour le moment par " . $pseudo . "</br>";
		lienArriere();
	}
	else {
		afficheURLs($pseudo);	
		lienArriere();
		echo "<a href='statistiques.php'>Statistiques d'utilisation</a>";
	}
  finHTML();
}
?>
