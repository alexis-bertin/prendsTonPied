<?php
	require_once("Marque.class.php");
	$Marque=Marque::getAllMarques();
	header('Content-type: text/xml; charset=utf-8');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	echo("<marque>\n");
	foreach($Marque as $m){
		echo("\t<marque nom=\"{$m->nomMarque}\">{$m->nomMarque}</marque>\n");
	}		
	echo("</marque>\n");
?>