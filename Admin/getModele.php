<?php
	require_once("Modele.class.php");
	$Modele=Modele::getModeleBYName($_GET["modeleName"]);
	header('Content-type: text/json');
	echo json_encode($Modele);
?>