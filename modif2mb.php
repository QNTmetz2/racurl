<?php
include('tools.php');
require 'rb.phar';
R::setup('mysql:host=localhost;dbname=racurl','racurluser','racurlpwd');
R::debug (TRUE, 1);
?>


<?php
function existe($id) {
	$m = R::load('membres', $id);
	if ($m->id == 0)
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
	echo "<a href='adm.php'>Retour</a>";
}
?>

<?php
session_start();
if (!isset($_SESSION['pseudo']))
    header('Location: index.php');
else {
	$id = trim($_POST['id']);
	$_SESSION['id'] = $id;
	if (existe($id) == false) {
		enteteTitreHTML('Recherche du membre a modifier');
		$erreur = "Il n'y a pas de membre sous cet id";
		afficheErreur($erreur);
		lienArriere();
		finHTML();
	}	
	else
		header('Location: modif3mb.php');
}		
?>
