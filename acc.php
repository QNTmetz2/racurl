<?php
include('tools.php');
require 'rb.phar';
R::setup('mysql:host=localhost;dbname=racurl','racurluser','racurlpwd');
R::debug (TRUE, 1);
?>

<?php
function existe($courte) {
	$bind = array("$courte");
	$num = R::count('urls', 'courte = ?', $bind);
	if ($num == 0)
		return false;
	else
		return true;
}

function getSource($courte) {
	$bind = array($courte);
	$url = R::findOne('urls', 'courte = ?', $bind);
	$util = R::dispense('utilisations');
	$util->url = $url->id;
	R::store($util);
	$source = $url->source;
	return $source;
}

function afficheErreur($erreur)
{
echo <<<ERR
<div class="erreur"> $erreur </div>
ERR;
}

function lienArriere() {
	echo "<a href='index.php'>Retour</a>";
}

?>

<?php
$courte = $_SESSION['courte'];
if (existe($courte)) {
	$source = getSource($courte);
	header("Location: $source");
}
else {
	enteteTitreHTML('Accéder à une URL');
	$erreur = "Le raccourci fourni n'existe pas";
	afficheErreur($erreur);
	lienArriere();
	finHTML();
}
?>
