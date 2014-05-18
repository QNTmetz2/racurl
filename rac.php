<?php
include('tools.php');
require 'rb.phar';
R::setup('mysql:host=localhost;dbname=racurl','racurluser','racurlpwd');
R::debug (TRUE, 1);
?>

<?php

function selectChar($hash) {
	$nb = rand(0,7);
	$tab = str_split($hash);
	$courte = "";
	for ($i=$nb;$i<32;$i+=4)
		$courte .= $tab[$i];
	return $courte;
}

function verifieCourte($courte) {
	$bind = array("$courte");
	$num = R::count('urls', 'courte = ?', $bind);
	while ($num>0) {
		$nb = hexdec($courte);
		$nb++;
		$courte = dechex($nb);
		$bind = array("$courte");
		$num = R::count('urls', 'courte = ?', $bind);
	}
	return $courte;
}

function ajouteURL($source) {
	$u = R::dispense('urls');
	$u->source = $source;
	
	$hash = md5($source);
	$courte = selectChar($hash);
	$courte = verifieCourte($courte);
	$u->courte = $courte;
	if (isset($_SESSION['pseudo'])) {
		$pseudo = $_SESSION['pseudo'];
		$bind = array("$pseudo");
		$m = R::findOne('membres', 'pseudo = ?', $bind);
		$auteur = $m->id;
		$u->auteur = $auteur;
	};
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
		<td><a href=$source>$courte</a></td>
	</tr>
	<tr>
		<th>Date de création</th>
		<td>$creation</td>
	</tr>
TAB;
if (isset($_SESSION['pseudo']))
{
echo <<<LINE
	<tr>
		<th>Auteur</th>
		<td>$auteur</td>
	</tr>
LINE;
}
echo "</table>";
echo "<a href='index.php'>Retour</a>";
finHTML();
}
?>

<?php
$source = $_SESSION['source'];
$id = ajouteURL($source);
afficheCourte($id);
?>
