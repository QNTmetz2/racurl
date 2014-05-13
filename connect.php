<?
include('tools.php');
require 'rb.phar';
R::setup('mysql:host=localhost;dbname=racurl','racurluser','racurlpwd');
R::debug (TRUE, 1);

function genereFormulaire($pseudo = "", $password = "")
{
echo <<<CNCT
	<form method="post" action="$_SERVER[PHP_SELF]" name="connect">
		<table>
			<tr> <td> Pseudo: </td> <td> <input type="text" name="pseudo" value= "$pseudo" /> <td> </tr>
			<tr> <td> Mot de passe: </td> <td> <input type="text" name="password" value= "$password" /> <td> </tr>
			<tr> <td></td> <td> <input type="submit" name="Go to go!" /> <td> </tr>	
			<input type="hidden" name="fromform" />
		</table>	
	</form>
CNCT;
}

function verifieFormulaire($pseudo, $password) {

	$erreur = "";
	$bind = array("$pseudo");
	$num = R::count('membres', 'pseudo = ?', $bind);
	if ($num == 0) {
		$erreur = "Le pseudo ". "$pseudo" . " n'est associé à aucun compte" . "</br>";
		genereFormulaire();
	}
	else {
		$m = R::findOne('membres', 'pseudo = ?', $bind);
		$hash = $m->mdp;
		if (crypt($password, $hash) != $hash)
			$erreur = "Mot de passe incorrect" . "</br>";
	}
	return $erreur;		
}

function afficheErreur($erreur)
{
echo <<<ERR
<div class="erreur"> $erreur </div>
ERR;
}
?>

<?php
enteteTitreHTML('Connexion au site');
if (isset($_POST['fromform'])) {
	$pseudo = trim($_POST['pseudo']);
	$password = trim($_POST['password']);
	$erreur = verifieFormulaire($pseudo, $password);
	if ($erreur == "") {
		$_SESSION['pseudo'] = $pseudo;
		$bind = array("$pseudo");
		$m = R::findOne('membres', 'pseudo = ?', $bind);
		$profil = $m->profil;
		if ($profil == "administrateur")
			header('Location: myadmin.php');
		else if ($profil == "utilisateur")
			header('Location: index.php');
	}
	else {
		genereFormulaire();
		afficheErreur($erreur);
	}
}
else
	genereFormulaire();
finHTML();
?>
