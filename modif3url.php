<?php
include('tools.php');
require 'rb.phar';
R::setup('mysql:host=localhost;dbname=racurl','racurluser','racurlpwd');
R::debug (TRUE, 1);
?>

<?php
function genereFormulaire($id) {
	$u = R::load('urls', $id);
	$source = $u->source;
	$courte = $u->courte;
	$creation = $u->creation;
	$auteur = $u->auteur;
    echo <<<FORM
	<form method="post" action="modif4url.php" name="formulaire">
	ID: $id <br />
	Source:
	<input type="text" name="source" value= $source >
	<br />
	Raccourci:
	<input type="text" name="courte" value= $courte >
	<br />
	Date de création:
	<input type="text" name="creation" value= $creation >
	<br />
	ID de l'auteur:
	<input type="text" name="auteur" value= $auteur >
	<br />
	<input type="submit" value="C'est parti !" >
	<a href='admurl.php'>Retour</a>
    </form>
FORM;
}
?>

<?php
if (!isset($_SESSION['pseudo']))
    header('Location: index.php');
else {
	enteteTitreHTML('Modifier une URL');
	$id = $_SESSION['id'];
	genereFormulaire($id);
	finHTML();
}
?>
