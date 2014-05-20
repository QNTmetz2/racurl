<?php
include('config.php');
?>

<?php

function supprimerURL($courte) {
	$bind = array($courte);
	$u = R::findOne('urls', 'courte = ?', $bind);
	$id = $u->id;
	$u = R::load('urls', $id);
	R::trash($u);
}

?>

<?php
if (!empty($_POST['todelete'])) {
    foreach($_POST['todelete'] as $courte)
		supprimerURL($courte);
	header('Location: myaccount.php');
}
else
	header('Location: myaccount.php');
?>
