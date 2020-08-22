<?php
	$user='dbo674212202';
	$mdp='Alex040698';
	$dsm="mysql:host=db674212202.db.1and1.com;dbname=db674212202";
	try {
		$cx=new PDO($dsm,$user,$mdp);
		$cx->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
		echo "ERREUR :".$e->getMessage()."<br/>";
		die();
	}
?>