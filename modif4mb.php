<?php
include('tools.php');
require 'rb.phar';
R::setup('mysql:host=localhost;dbname=racurl','racurluser','racurlpwd');
R::debug (TRUE, 1);
?>

<?php
function verifieFormulaire($nom, $prenom, $pseudo, $mail, $activation, $profil) {
	$erreur = "";
	if ($nom == "")
		$erreur .= "Le nom ne peut être vide" . "</br>";
	if ($prenom == "")
		$erreur .= "Le prenom ne peut être vide" . "</br>";
	if ($pseudo == "")
		$erreur .= "Le pseudo ne peut être vide" . "</br>";
	if ($mail == "")
		$erreur .= "Le mail ne peut être vide" . "</br>";
	if ($activation == "")
		$erreur .= "Le mode d'activation ne peut être vide" . "</br>";
	if ($profil == "")
		$erreur .= "Le profil ne peut être vide" . "</br>";
	return $erreur;
}

function rangerMembre($id,$nom,$prenom,$pseudo,$mail,$activation,$profil) {
	$m = R::load('membres', $id);
	$m->nom = $nom;
	$m->prenom = $prenom;
	$m->pseudo = $pseudo;
	$m->mail = $mail;
	$m->activation = $activation;
	$m->profil = $profil;
	R::store($m);
}

function afficherRes($id) {
	$m = R::load('membres', $id);
	$nom = $m->nom;
	$prenom = $m->prenom;
	$pseudo = $m->pseudo;
	$mail = $m->mail;
	$activation = $m->activation;
	$profil = $m->profil;
    echo <<<TAB
	Vos modifications ont bien ete enregistrees
	<br />
	<table>
    <tr>
		<th>ID</th>
		<th>Nom</th>
		<th>Prenom</th>
		<th>Pseudo</th>
		<th>Mail</th>
		<th>Activation</th>
		<th>Profil</th>
    <tr>
	<tr>
		<td>$id</td>
		<td>$nom</td>
		<td>$prenom</td>
		<td>$pseudo</td>
		<td>$mail</td>
		<td>$activation</td>
		<td>$profil</td>
    </tr>
    </table>
TAB;
}

function lienArriere() {
	echo "<a href='adm.php'>Retour</a>";
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
	enteteTitreHTML('Modifier un membre');
	$id = $_SESSION['id'];
	$nom = trim($_POST['nom']);
	$prenom = trim($_POST['prenom']);
	$pseudo = trim($_POST['pseudo']);
	$mail = trim($_POST['mail']);
	$activation = trim($_POST['activation']);
	$profil = trim($_POST['profil']);
	$erreur = verifieFormulaire($nom,$prenom,$pseudo,$mail,$activation,$profil);
	if ($erreur == "") {
		rangerMembre($id,$nom,$prenom,$pseudo,$mail,$activation,$profil);
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