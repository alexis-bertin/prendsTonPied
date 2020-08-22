<?php session_start() ?>
<html>
 <head>
  <title>Test PHP</title>
 </head>
 <body>
<?php

require_once('connexions.php');
if (!$_SESSION['admin']){
	header('location:login.php');
}
$req = $cx->query('SELECT * FROM Client');
$user = $req->fetch();


?>

<?php


?>
 </body>
</html>
