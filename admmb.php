<?php
include('tools.php');

function genereFormulaire()
{
echo <<<ADM
<form method="GET" action="$_SERVER[PHP_SELF]" name="formulaire">
	<input type="radio" name="action" value="visu"/>
		Visualiser un membre
		<br>
	<input type="radio" name="action" value="modif"/>
		Modifier un membre
		<br>
	<input type="radio" name="action" value="sup"/>
		Supprimer un membre
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
	enteteTitreHTML('Administration de la table membres');
	if (isset($_GET['fromform'])) {
		if (strip_tags($_GET['action']) == 'visu')
			header('Location: visumb.php');
		else if (strip_tags($_GET['action']) == 'modif')
			header('Location: modif1mb.php');
		else if (strip_tags($_GET['action']) == 'sup')
			header('Location: sup1mb.php');
	}
	else
		genereFormulaire();
}
finHTML();
?>
