 <?php
include('connexions.php');
$name=$_FILES['image']['name'];
$type=$_FILES['image']['type'];
if($_FILES['image']['error']>0) { echo "<span class='alert'>Erreur lors du transfert </span><br/>";}
if ($_FILES['image']['size']>$maxsize) echo $erreur="Le fichier est trop gros";
$extensions_valide= array('jpg', 'jpeg');
$extension_upload=strtolower(substr(strrchr($_FILES['image']['name'],'.'),1));
if (in_array($extension_upload,$extensions_valide)) echo "Extension correcte";
$image_sizes= getimagesize($_FILES['image']['tmp_name']);
if($image_sizes[0]>$maxwidth || $image_sizes[1]>$maxheight)echo $erreur="Image trop grande";
?>