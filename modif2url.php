<?php
include('tools.php');
include('config.php');
?>


<?php
function existe($id) {
	$u = R::load('urls', $id);
	if ($u->id == 0)
		return false;
	else
		return true;
}

function afficheErreur($erreur)
{
echo <<<ERR
<div class="erreur"> $erreur </div>
ERR;
}

function lienArriere() {
	echo "<a href='admurl.php'>Retour</a>";
}
?>

<?php
session_start();
if (!isset($_SESSION['pseudo']))
    header('Location: index.php');
else {
	$id = strip_tags(trim($_POST['id']));
	$_SESSION['id'] = $id;
	if (existe($id) == false) {
		enteteTitreHTML("Recherche de l'URL a modifier");
		$erreur = "Il n'y a pas d'URL sous cet id";
		afficheErreur($erreur);
		lienArriere();
		finHTML();
	}	
	else
		header('Location: modif3url.php');
}		
?>
