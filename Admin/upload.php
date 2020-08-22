<?php
require_once('connexions.php');
$titre = htmlentities($_POST['titre']);
$fichier= $_FILES['fileToUpload']['name'];
$article = htmlentities($_POST['texte']);
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "Image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Le fichier n'est pas une image";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Le fichier existe déjà";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Fichier trop gros";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Mauvais formats";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Fichier non uploadé";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      PDOConnexion::setParameters("db716067759", "dbo716067759", "w8198-56472rtW");
      $db= PDOConnexion::getInstance();
      $sql="INSERT INTO article(article, titre) VALUES (:article, :titre)";
      $sth= $db-> prepare($sql);
      $sth -> execute(array(":article"=>$article, ":titre"=>$titre));
      $db2 = PDOConnexion::getInstance();
      $sql2 = "INSERT INTO images(titreImage) VALUES (:titreImage)";
      $sth2 = $db2 -> prepare($sql2);
      $sth2 -> execute(array(":titreImage" => $fichier));
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " image uploadé.";
        echo "<img src="."images/".basename($_FILES["fileToUpload"]["name"])."/>";
    } else {
        echo "Erreur avec l'upload de votre image";
    }
}
?>
