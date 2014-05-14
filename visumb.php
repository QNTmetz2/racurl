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
	  <input type="radio" name="typerech" value="pseudo" onchange="majzone();" />
	  Recherche par pseudo
	  <br />
	  <input type="text" name="filtre2" style="visibility:hidden"/>
	  <br />
	  <input type="submit" value="C'est parti !" />
	  <input type="hidden" name="fromform" />
	  <a href='admmb.php'>Retour</a>
	</form>
FORM;
}

function lienArriere() {
	echo "<a href='admmb.php'>Retour</a>";
}

function existe1($id) {
	$m = R::load('membres', $id);
	if ($m->id == 0)
		return false;
	else
		return true;
}

function existe2($pseudo) {
	$bind = array("$pseudo");
	$num = R::count('membres', 'pseudo = ?', $bind);
	if ($num == 0)
		return false;
	else
		return true;
}

function afficheRes1($id) {
	$m = R::load('membres', $id);
	$nom = $m->nom;
	$prenom = $m->prenom;
	$pseudo = $m->pseudo;
	$mail = $m->mail;
	$activation = $m->activation;
	$profil = $m->profil;
    echo <<<TAB
	<table>
    <tr>
		<th>ID</th>
		<th>Nom</th>
		<th>Prenom</th>
		<th>Pseudo</th>
		<th>Mail</th>
		<th>Activation</th>
		<th>Profil</th>
    <tr>
	<tr>
		<td>$id</td>
		<td>$nom</td>
		<td>$prenom</td>
		<td>$pseudo</td>
		<td>$mail</td>
		<td>$activation</td>
		<td>$profil</td>
    </tr>
    </table>
TAB;
}

function afficheRes2($pseudo) {
	$bind = array($pseudo);
	$m = R::findOne('membres', 'pseudo = ?', $bind);
	$id = $m->id;
	$nom = $m->nom;
	$prenom = $m->prenom;
	$mail = $m->mail;
	$activation = $m->activation;
	$profil = $m->profil;
	echo <<<TAB
	<table>
	<tr>
		<th>ID</th>
		<th>Nom</th>
		<th>Prenom</th>
		<th>Pseudo</th>
		<th>Mail</th>
		<th>Activation</th>
		<th>Profil</th>
	<tr>
	<tr>
		<td>$id</td>
		<td>$nom</td>
		<td>$prenom</td>
		<td>$pseudo</td>
		<td>$mail</td>
		<td>$activation</td>
		<td>$profil</td>
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
	enteteTitreHTML('Visualiser un membre');
	if (isset($_GET['fromform'])) {
		if ($_GET['typerech'] == 'id') {
			$id = trim($_GET['filtre1']);
			if (existe1($id) == true) {
				afficheRes1($id);
				lienArriere();
			}
			else {
				$erreur = "Il n'y a pas de membre sous cet id";
				afficheErreur($erreur);
				lienArriere();
			}
		}
		else {
			$pseudo = trim($_GET['filtre2']);
			if (existe2($pseudo) == true) {
				afficheRes2($pseudo);
				lienArriere();
			}
			else {
				$erreur = "Il n'y a pas de membre sous ce pseudo";
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
