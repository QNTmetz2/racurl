<?php

//include('myaccount.php');

$urls=array(8);//compteURL($pseudo));
$bind1 = array($pseudo);
$m = R::findOne('membres', 'pseudo = ?', $bind1);
$id = $m->id;
$bind2 = array($id);
$urls = R::findAll('urls', 'auteur = ?', $bind2);

foreach($urls as $value){
$bind3=array($value->id);
$usages=R::count('utilisations','url = ?',$bind3);
echo "['".$value->source."',".$usages."]";
}
?>
