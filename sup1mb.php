<?php
include('tools.php');
?>

<?php
function genereFormulaire() {
echo <<<FORM
	<form method="post" action= "sup2mb.php" name="formulaire">
	  ID du membre a supprimer:
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
	enteteTitreHTML("Saisie de l'ID du membre a supprimer");
	genereFormulaire();
	finHTML();
}
?>
