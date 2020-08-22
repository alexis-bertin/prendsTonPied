<?php
	session_start(); 
	setcookie('auto_prendstonpied','',time(), '/');
	setcookie('id_prendstonpied','',time(), '/');
	setcookie('mdp_prendstonpied','',time(), '/');
	setcookie('nom_prendstonpied','',time(), '/');
	setcookie('prenom_prendstonpied','',time(), '/');
	setcookie('cp_prendstonpied','',time(), '/');
	setcookie('ville_prendstonpied','',time(), '/');
	setcookie('norue_prendstonpied','',time(), '/');
	setcookie('nurue_prendstonpied','',time(), '/');
	setcookie('appart_prendstonpied','',time(), '/');
	setcookie('tel_prendstonpied','',time(), '/');

	$_SESSION=array(); 
   session_destroy();		
   session_unset();
	header ("Location:../index.php"); 
	die(); 
?>