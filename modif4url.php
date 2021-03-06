<?php
include('tools.php');
include('config.php');
?>

<?php
function verifieFormulaire($source, $courte, $creation, $auteur) {
	$erreur = "";
	if ($source == "")
		$erreur .= "La source ne peut être vide" . "</br>";
	if ($courte == "")
		$erreur .= "Le raccourci ne peut être vide" . "</br>";
	if ($creation == "")
		$erreur .= "La date ne peut etre vide" . "</br>";
	if ($auteur != "") {
		if (!filter_var($auteur, FILTER_VALIDATE_INT))
			$erreur .= "L'ID de l'auteur doit être un entier" . "</br>";
		else {
			$m = R::load('membres', $auteur);
			if ($m->id == 0)
				$erreur .= "L'auteur n'existe pas" . "</br>";
		}
	}
	return $erreur;
}

function rangerURL($id,$source, $courte, $creation, $auteur) {
	$u = R::load('urls', $id);
	$u->source = $source;
	$u->courte = $courte;
	$u->creation = $creation;
	if ($auteur == "")
		$u->auteur = NULL;
	else
		$u->auteur = $auteur;
	R::store($u);
}

function afficherRes($id) {
	$u = R::load('urls', $id);
	$source = $u->source;
	$courte = $u->courte;
	$creation = $u->creation;
	$auteur = $u->auteur;
    echo <<<TAB
	Vos modifications ont bien ete enregistrees
	<br />
	<table>
    <tr>
		<th>ID</th>
		<th>Source</th>
		<th>Courte</th>
		<th>Création</th>
		<th>Auteur</th>
    <tr>
	<tr>
		<td>$id</td>
		<td>$source</td>
		<td>$courte</td>
		<td>$creation</td>
		<td>$auteur</td>
    </tr>
    </table>
TAB;
}

function lienArriere1() {
	echo "<a href='admurl.php'>Retour</a>";
}

function lienArriere2() {
	echo "<a href='modif3url.php'>Retour</a>";
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
	enteteTitreHTML('Modifier une URL');
	$id = $_SESSION['id'];
	$source = strip_tags(trim($_POST['source']));
	$courte = strip_tags(trim($_POST['courte']));
	$creation = strip_tags(trim($_POST['creation']));
	$auteur = strip_tags(trim($_POST['auteur']));
	$erreur = verifieFormulaire($source, $courte, $creation, $auteur);
	if ($erreur == "") {
		rangerURL($id,$source, $courte, $creation, $auteur);
		afficherRes($id);
		lienArriere1();
	}
	else {
		afficheErreur($erreur);
		lienArriere2();
	}
	finHTML();		
}		
?>
