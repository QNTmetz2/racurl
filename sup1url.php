<?php
include('tools.php');
?>

<?php
function genereFormulaire() {
echo <<<FORM
	<form method="post" action= "sup2url.php" name="formulaire">
	  ID de l'URL à supprimer:
	  <input type="text" name="id"/>
	  <br />
	  <input type="submit" value="C'est parti !" />
	  <a href='admurl.php'>Retour</a>
	</form>
FORM;
}

?>

<?php
if (!isset($_SESSION['pseudo']))
    header('Location: index.php');
else {
	enteteTitreHTML("Saisie de l'ID de l'URL à supprimer");
	genereFormulaire();
	finHTML();
}
?>
