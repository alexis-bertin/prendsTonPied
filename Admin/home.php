<?php session_start() ?>
<html>
 <head>
  <title>Test PHP</title>
 </head>
 <body>
 <h3>Bienvenue <?= $_SESSION['admin']?> </h3>
<?php

require_once'connexions.php';

?>

<?php

$req = $cx->query('SELECT * FROM Chaussures');
$chaussures = $req->fetchAll();
foreach ($chaussures as $chaussure) {
	echo $chaussure['id_chaussure'];
}


?>
 </body>
</html>