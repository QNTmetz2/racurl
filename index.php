<?php
include('tools.php');
require 'rb.phar';
R::setup('mysql:host=localhost;dbname=racurl','racurluser','racurlpwd');
R::debug (TRUE, 1);
?>

<?

function affichePseudo($pseudo, $profil) {
echo "<table><tr><td>Connecté comme</td><td>";
if ($profil == "utilisateur")
	echo "<a href='myaccount.php'>";
else
	echo "<a href='myadmin.php'>";
echo $pseudo . "</a></td><td>";
echo "<a href='logout.php'>Se déconnecter</a></td></tr></table>";
}

function accueilleVteur() {
echo <<<JS
	<script language="JavaScript">
	 function majzone()
	 {
	   if (document.formulaire.start[0].checked) {
		 	document.formulaire.filtre2.style.visibility = "hidden";
		 	document.formulaire.filtre2.value = "";
	   		document.formulaire.filtre1.style.visibility = "visible";
		}
	   else if (document.formulaire.start[1].checked) {
		 document.formulaire.filtre1.style.visibility = "hidden";
		 document.formulaire.filtre1.value = "";
		 document.formulaire.filtre2.style.visibility = "visible";
	   }
	   else {
		 document.formulaire.filtre1.style.visibility = "hidden";
		 document.formulaire.filtre1.value = "";
		 document.formulaire.filtre2.style.visibility = "hidden";
		 document.formulaire.filtre2.value = "";
	   }
	 }
	</script>
JS;
echo <<<START
	<form method="GET" action="$_SERVER[PHP_SELF]" name="formulaire">
		<input type="radio" name="start" value="rac" onchange="majzone();" checked="checked"/>
	  	Raccourcir l'URL
	  	<br />
	  	<input type="text" name="filtre1" style="visibility:visible"/>
	  	<br />
		<input type="radio" name="start" value="acc" onchange="majzone();" />
	  	Accéder à l'URL
	  	<br />
	  	<input type="text" name="filtre2" style="visibility:hidden"/>
	  	<br />
START;
if (!isset($_SESSION['pseudo'])) {
echo <<<START
		<input type="radio" name="start" value="dejcree" onchange="majzone();">
		Se connecter avec pseudo et mot de passe
		<br>
		<input type="radio" name="start" value="acreer" onchange="majzone();">
		Créer un compte
		<br>
START;
}
echo <<<START
	<input type="hidden" name="fromform" />
	<input type="submit" name="Go to go!" />
	</form>
START;
}
?>

<?php
if (isset($_GET['fromform'])) {
	if ($_GET[start] == 'dejcree')
		header('Location: connect.php');
	else if ($_GET[start] == 'acreer')
		header('Location: enreg.php');
	else if ($_GET[start] == 'rac') {
		$_SESSION['source'] = trim($_GET['filtre1']);
		header('Location: rac.php');
	}
	else if ($_GET[start] == 'acc') {
		$_SESSION['courte'] = trim($_GET['filtre2']);
		header('Location: acc.php');
	}
}
else {
	enteteHTML('Raccourcir une URL');
	if (isset($_SESSION['pseudo'])) {
		$pseudo = $_SESSION['pseudo'];
		$bind = array("$pseudo");
		$m = R::findOne('membres', 'pseudo = ?', $bind);
		$profil = $m->profil;
		affichePseudo($pseudo,$profil);		
	}
	titreHTML('Raccourcir une URL');
	accueilleVteur();
	finHTML();
}
?>
