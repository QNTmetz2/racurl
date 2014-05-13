<?php
include('tools.php');
require 'rb.phar';
R::setup('mysql:host=localhost;dbname=racurl','racurluser','racurlpwd');
R::debug (TRUE, 1);
define("SALT", "octobre");
?>

<?php
function ajouteURL($source) {
	$u = R::dispense('urls');
	$u->source = $source;
	$hash = crypt($source, SALT);
/*	$hash = verifieAdresse($hash);*/
	$u->courte = $hash;
	if (isset($_SESSION['pseudo'])) {
		$pseudo = $_SESSION['pseudo'];
		$bind = array("$pseudo");
		$m = R::findOne('membres', 'pseudo = ?', $bind);
		$auteur = $m->id;
	}
	else
		$auteur = 0;
	$u->auteur = $auteur;
	$id = R::store($u);
	return $id;
}

function afficheCourte($id) {
	$u = R::load('urls',$id);
	$source = $u->source;
	$courte = $u->courte;
	$creation = $u->creation;
	$auteur = $u->auteur;
	enteteTitreHTML('Votre URL courte');
    echo <<<TAB
	Votre URL courte a été correctement générée
	<br />
	<table>
    <tr>
		<th>URL source</th>
		<td>$source</td>
	</tr>
	<tr>
		<th>URL courte</th>
		<td>$courte</td>
	</tr>
	<tr>
		<th>Date de création</th>
		<td>$creation</td>
	</tr>
	<tr>
		<th>Auteur</th>
		<td>$auteur</td>
	</tr>
    </table>
TAB;
	finHTML();
}
?>

<?php
$source = $_SESSION['source'];
$id = ajouteURL($source);
afficheCourte($id);
?>