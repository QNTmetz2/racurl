<?php
include('tools.php');

function genereFormulaire()
{
echo <<<ADM
<form method="GET" action="$_SERVER[PHP_SELF]" name="formulaire">
	<input type="radio" name="action" value="visu"/>
		Visualiser une URL
		<br>
	<input type="radio" name="action" value="modif"/>
		Modifier une URL
		<br>
	<input type="radio" name="action" value="sup"/>
		Supprimer une URL
		<br>
	<input type="submit" name="C'est parti !" />
	<input type="hidden" name="fromform" />
	<a href='myadmin.php'>Retour</a>
</form>
ADM;
}

if (!isset($_SESSION['pseudo']))
    header('Location: index.php');
else {
	enteteTitreHTML('Administration de la table urls');
	if (isset($_GET['fromform'])) {
		if ($_GET['action'] == 'visu')
			header('Location: visuurl.php');
		else if ($_GET['action'] == 'modif')
			header('Location: modif1url.php');
		else if ($_GET['action'] == 'sup')
			header('Location: sup1url.php');
	}
	else
		genereFormulaire();
}
finHTML();
?>
