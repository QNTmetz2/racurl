<?php
include('tools.php');
?>

<?php
function genereFormulaire() {
echo <<<FORM
	<form method="post" action= "modif2mb.php" name="formulaire">
	  ID du membre a modifier:
	  <input type="text" name="id"/>
	  <br />
	  <input type="submit" value="C'est parti !" />
	  <a href='admmb.php'>Retour</a>
	</form>
FORM;
}
?>

<?php
if (!isset($_SESSION['pseudo']))
    header('Location: index.php');
else {
	enteteTitreHTML('Recherche du membre a modifier');
	genereFormulaire();
	finHTML();
}
?>
