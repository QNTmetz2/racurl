<?php
include('tools.php');

function genereFormulaire()
{
echo <<<ADM
<form method="GET" action="$_SERVER[PHP_SELF]" name="formulaire">
	<input type="radio" name="action" value="membres"/>
		Gérer les membres
		<br>
	<input type="radio" name="action" value="urls"/>
		Gérer les URLs
		<br>
	<input type="submit" name="C'est parti !" />
	<input type="hidden" name="fromform" />
	<a href='logout.php'>Se deconnecter</a>
</form>
ADM;
}
?>

<?
if (!isset($_SESSION['pseudo']))
    header('Location: index.php');
else {
	enteteTitreHTML('Administration de la base racurl');
	if (isset($_GET['fromform'])) {
		if ($_GET['action'] == 'membres')
			header('Location: admmb.php');
		else if ($_GET['action'] == 'urls')
			header('Location: admurl.php');
	}
	else
		genereFormulaire();
}
finHTML();
?>
