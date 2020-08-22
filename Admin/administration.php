<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="post" action="" enctype="multipart/form-data">
<label for="mon_file">Fichier (Tous formats | max. 1 Mo):</label><br/>
<input type="hidden" name="MAX_FILE_SIZE" value="1048576"/>
<input type="file" name="image"/>
<?php
require_once('connexions.php');
$name=$_FILES['image']['name'];
$type=$_FILES['image']['type'];
if($_FILES['image']['error']>0) $erreur = "Erreur lors du transfert";
if ($_FILES['image']['size']>$maxsize)$erreur="Le fichier est trop gros";
$extensions_valide= array('jpg', 'jpeg');
$extension_upload=strtolower(substr(strrchr($_FILES['image']['name'],'.'),1));
if (in_array($extension_upload,$extensions_valide)) echo "Extension correcete";
$image_sizes= getimagesize($_FILES['image']['tmp_name']);
if($image_sizes[0]>$maxwidth || $image_sizes[1]>$maxheight) $erreur="Image trop grande";
?>
<input type="submit" name="submit" value="Envoyer" />
</form>
</body>
</html>

