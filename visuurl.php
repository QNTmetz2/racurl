<?php
include('tools.php');
require 'rb.phar';
R::setup('mysql:host=localhost;dbname=racurl','racurluser','racurlpwd');
R::debug (TRUE, 1);
?>

<?php
function genereFormulaire() {
echo <<<JS
	<script language="JavaScript">
	 function majzone()
	 {
	   if (document.formulaire.typerech[0].checked) {
		 	document.formulaire.filtre2.style.visibility = "hidden";
		 	document.formulaire.filtre2.value = "";
	   		document.formulaire.filtre1.style.visibility = "visible";
		}
	   else {
		 document.formulaire.filtre1.style.visibility = "hidden";
		 document.formulaire.filtre1.value = "";
		 document.formulaire.filtre2.style.visibility = "visible";
	   }

	 }
	</script>
JS;

echo <<<FORM
	<form method="get" action="$_SERVER[PHP_SELF]" name="formulaire">
	  <input type="radio" name="typerech" value="id" onchange="majzone();" />
	  Recherche par id
	  <br />
	  <input type="text" name="filtre1" style="visibility:hidden"/>
	  <br />
	  <input type="radio" name="typerech" value="url" onchange="majzone();" />
	  Recherche par URL courte
	  <br />
	  <input type="text" name="filtre2" style="visibility:hidden"/>
	  <br />
	  <input type="submit" value="C'est parti !" />
	  <input type="hidden" name="fromform" />
	  <a href='adm.php'>Retour</a>
	</form>
FORM;
}

function lienArriere() {
	echo "<a href='adm.php'>Retour</a>";
}

function existe1($id) {
	$u = R::load('urls', $id);
	if ($u->id == 0)
		return false;
	else
		return true;
}

function existe2($courte) {
	$bind = array("$courte");
	$num = R::count('urls', 'courte = ?', $bind);
	if ($num == 0)
		return false;
	else
		return true;
}

function afficheRes1($id) {
	$u = R::load('urls', $id);
	$source = $u->source;
	$courte = $u->courte;
	$creation = $u->creation;
	$auteur = $u->auteur;
    echo <<<TAB
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

function afficheRes2($courte) {
	$bind = array($courte);
	$u = R::findOne('urls', 'courte = ?', $bind);
	$id = $u->id;
	$source = $u->source;
	$courte = $u->courte;
	$creation = $u->creation;
	$auteur = $u->auteur;
	echo <<<TAB
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
	enteteTitreHTML('Visualiser une URL');
	if (isset($_GET['fromform'])) {
		if ($_GET['typerech'] == 'id') {
			$id = trim($_GET['filtre1']);
			if (existe1($id) == true) {
				afficheRes1($id);
				lienArriere();
			}
			else {
				$erreur = "Il n'y a pas d'URL sous cet id";
				afficheErreur($erreur);
				lienArriere();
			}
		}
		else {
			$courte = trim($_GET['filtre2']);
			if (existe2($courte) == true) {
				afficheRes2($courte);
				lienArriere();
			}
			else {
				$erreur = "Il n'y a pas d'URL sous ce raccourci";
				afficheErreur($erreur);
				lienArriere();
			}
		}
	}
	else	
		genereFormulaire();
	finHTML();
}
?>
