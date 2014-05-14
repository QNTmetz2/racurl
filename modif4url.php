<?php
include('tools.php');
require 'rb.phar';
R::setup('mysql:host=localhost;dbname=racurl','racurluser','racurlpwd');
R::debug (TRUE, 1);
?>

<?php
function verifieFormulaire($source, $courte, $creation, $auteur) {
	$erreur = "";
	if ($source == "")
		$erreur .= "La source ne peut être vide" . "</br>";
	if ($courte == "")
		$erreur .= "Le raccourci ne peut être vide" . "</br>";
	if ($creation == "")
		$erreur .= "La date ne peut etre vide" . "</br>";
	if ($auteur == "")
		$erreur .= "L'auteur ne peut être vide" . "</br>";
	return $erreur;
}

function rangerURL($id,$source, $courte, $creation, $auteur) {
	$u = R::load('urls', $id);
	$u->source = $source;
	$u->courte = $courte;
	$u->creation = $creation;
	$u->auteur = $auteur;
	R::store($u);
}

function afficherRes($id) {
	$u = R::load('urls', $id);
	$source = $u->source;
	$courte = $u->courte;
	$creation = $u->creation;
	$auteur = $u->auteur;
    echo <<<TAB
	Vos modifications ont bien ete enregistrees
	<br />
	<table>
    <tr>
		<th>ID</th>
		<th>Source</th>
		<th>Courte</th>
		<th>Création</th>
		<th>Auteur</th>
    <tr>
	<tr>
		<td>$id</td>
		<td>$source</td>
		<td>$courte</td>
		<td>$creation</td>
		<td>$auteur</td>
    </tr>
    </table>
TAB;
}

function lienArriere() {
	echo "<a href='admurl.php'>Retour</a>";
}

function afficheErreur($erreur)
{
echo <<<ERR
<div class="erreur"> $erreur </div>
ERR;
}
?>

<?php
if (!isset($_SESSION['pseudo']))
    header('Location: index.php');
else {
	enteteTitreHTML('Modifier une URL');
	$id = $_SESSION['id'];
	$source = trim($_POST['source']);
	$courte = trim($_POST['courte']);
	$creation = trim($_POST['creation']);
	$auteur = trim($_POST['auteur']);
	$erreur = verifieFormulaire($source, $courte, $creation, $auteur);
	if ($erreur == "") {
		rangerMembre($id,$source, $courte, $creation, $auteur);
		afficherRes($id);
		lienArriere();
	}
	else {
		afficheErreur($erreur);
		lienArriere();
	}
	finHTML();		
}		
?>
