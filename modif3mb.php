<?php
include('tools.php');
include('config.php');
?>

<?php
function genereFormulaire($id) {
	$m = R::load('membres', $id);
	$nom = $m->nom;
	$prenom = $m->prenom;
	$pseudo = $m->pseudo;
	$mail = $m->mail;
	$activation = $m->activation;
	$profil = $m->profil;
    echo <<<FORM
	<form method="post" action="modif4mb.php" name="formulaire">
	ID: $id <br />
	Nom:
	<input type="text" name="nom" value= $nom >
	<br />
	Prenom:
	<input type="text" name="prenom" value= $prenom >
	<br />
	Pseudo:
	<input type="text" name="pseudo" value= $pseudo >
	<br />
	Mail:
	<input type="text" name="mail" value= $mail >
	<br />
	Activation:
	<input type="text" name="activation" value= $activation >
	<br />
	Profil:
	<input type="text" name="profil" value= $profil >
	<br />
	<input type="submit" value="C'est parti !" >
	<a href='admmb.php'>Retour</a>
    </form>
FORM;
}
?>

<?php
if (!isset($_SESSION['pseudo']))
    header('Location: index.php');
else {
	enteteTitreHTML('Modifier un membre');
	$id = $_SESSION['id'];
	genereFormulaire($id);
	finHTML();
}
?>
