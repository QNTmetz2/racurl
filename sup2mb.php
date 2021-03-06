<?php
include('tools.php');
include('config.php');
?>

<?php
function existe($id) {
	$m = R::load('membres', $id);
	if ($m->id == 0)
		return false;
	else
		return true;
}

function supprimerMembre($id) {
	$m = R::load('membres', $id);
	R::trash($m);
	echo "Le membre portant l'ID " . $id . " a été correctement supprimé" . "<br />";
}

function lienArriere() {
	echo "<a href='admmb.php'>Retour</a>";
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
	enteteTitreHTML('Supprimer un membre');
	$id = strip_tags(trim($_POST['id']));
	if (existe($id) == false) {
		$erreur = "Il n'y a pas de membre sous cet id";
		afficheErreur($erreur);
		lienArriere();
	}
	else {
		supprimerMembre($id);
		lienArriere();
	}
	finHTML();		
}		
?>
