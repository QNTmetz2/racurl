<?php
include('tools.php');
require 'rb.phar';
R::setup('mysql:host=localhost;dbname=racurl','racurluser','racurlpwd');
R::debug (TRUE, 1);
?>

<?php
function existe($id) {
	$u = R::load('urls', $id);
	if ($u->id == 0)
		return false;
	else
		return true;
}

function supprimerURL($id) {
	$u = R::load('urls', $id);
	R::trash($u);
	echo "Le raccourci portant l'ID " . $id . " a été correctement supprimé" . "<br />";
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
	enteteTitreHTML('Supprimer une URL');
	$id = $_POST['id'];
	if (existe($id) == false) {
		$erreur = "Il n'y a pas d'URL sous cet id";
		afficheErreur($erreur);
		lienArriere();
	}
	else {
		supprimerURL($id);
		lienArriere();
	}
	finHTML();		
}		
?>
