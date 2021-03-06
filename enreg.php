<?php
include('tools.php');
include('config.php');
define("SALT", "avril");

function genereFormulaire($nom = "", $prenom = "", $pseudo = "", $mail = "", $mdp1 = "", $mdp2 = "")
{
  echo <<<ENR
	<form method="post" action="$_SERVER[PHP_SELF]" name="enreg">
		<table>
			<tr> <td> Nom: </td> <td> <input type="text" name="nom" value= "$nom" /> <td> </tr>
			<tr> <td> Prénom: </td> <td> <input type="text" name="prenom" value= "$prenom" /> <td> </tr>
			<tr> <td> Pseudo: </td> <td> <input type="text" name="pseudo" value= "$pseudo" /> <td> </tr>
			<tr> <td> Mail: </td> <td> <input type="text" name="mail" value= "$mail" /> <td> </tr>
			<tr> <td> Mot de passe: </td> <td> <input type="password" name="mdp1" value= "$mdp1" /> <td> </tr>
			<tr> <td> Vérification du mot de passe: </td> <td> <input type="password" name="mdp2" value= "$mdp2" /> <td> </tr>
			<tr> <td> <input type="submit" value="Annuler" name="Go" /></td><td> <input type="submit" value="Valider &rarr;" name="Go" /> <td> 	</tr>
			<input type="hidden" name="fromform" />
		</table>	
	</form>
ENR;
}

function verifieFormulaire($nom, $prenom, $pseudo, $mail, $mdp1, $mdp2) {

	$erreur = "";
	if ($nom == "")
		$erreur .= "Le nom ne peut être vide" . "</br>";
	if ($prenom == "")
		$erreur .= "Le prenom ne peut être vide" . "</br>";
	if ($pseudo == "")
		$erreur .= "Le pseudo ne peut être vide" . "</br>";
	if ($mail == "")
		$erreur .= "Le mail ne peut être vide" . "</br>";
	if (($mdp1 == "")||($mdp2 == ""))
		$erreur .= "Le mot de passe ne peut être vide" . "</br>";	if ($pseudo != "") {
		$bind = array("$pseudo");
		$num = R::count('membres', 'pseudo = ?', $bind);
		if ($num>0)
			$erreur .= "Le pseudo est deja pris" . "</br>";
	}
	if ($mdp1 != $mdp2)
		$erreur .= "Les mots de passe ne concordent pas" . "</br>";
	return $erreur;
}

function ajouteMembre($nom, $prenom, $pseudo, $mail, $mdp1) {
	$m = R::dispense('membres');
	$m->nom = $nom;
	$m->prenom = $prenom;
	$m->pseudo = $pseudo;
	$m->mail = $mail;
	$hash = crypt($mdp1, SALT);
	$m->mdp = $hash;
	$m->activation = 'immediate';
	$num = R::count('membres');
	if ($num == 0)
		$profil = 'administrateur';
	else
		$profil = 'utilisateur';
	$m->profil = $profil;
	$id = R::store($m);
}

function afficheErreur($erreur)
{
echo <<<ERR
<div class="erreur"> $erreur </div>
ERR;
}

enteteTitreHTML('Création de compte');
if (isset($_POST['fromform'])) {
  $nom = strip_tags(trim($_POST['nom']));
  $prenom = strip_tags(trim($_POST['prenom']));
  $pseudo = strip_tags(trim($_POST['pseudo']));
  $mail = strip_tags(trim($_POST['mail']));
  $mdp1 = strip_tags(trim($_POST['mdp1']));
  $mdp2 = strip_tags(trim($_POST['mdp2']));
  $choix= strip_tags($_POST['Go']);
  $erreur = verifieFormulaire($nom, $prenom, $pseudo, $mail, $mdp1, $mdp2);

  if($choix == "Annuler")
    header('Location:index.php');
  else{
    if ($erreur == "") {
      ajouteMembre($nom, $prenom, $pseudo, $mail, $mdp1);
      header('Location: index.php');
    }else{
      genereFormulaire($nom, $prenom, $pseudo, $mail);
      afficheErreur($erreur);
    }		
  }
}else
genereFormulaire();
finHTML();
?>
