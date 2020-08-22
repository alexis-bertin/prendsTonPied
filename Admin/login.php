<?php session_start() ?>
<html>
 <head>
  <title>Test PHP</title>
  <?php

require_once('connexions.php');

?>
 </head>
 <body>
 <h3> Connexion </h3>

<?php
if(isset($_POST) AND !empty($_POST)){
	if(!empty(htmlspecialchars($_POST['email'])) AND !empty(htmlspecialchars($_POST['mdp']))){
		$req = $cx->prepare('SELECT * FROM Client WHERE email = :email AND mdp = :mdp');
		$req->execute([
			'email' => $_POST['email'],
			'mdp' => $_POST['mdp']
			]);
		$user = $req->fetch();
		if($user){
			$_SESSION['admin'] = $_POST['email'];
			header('location: ../index.php');
		}
		else{
		 $error = 'Identifiants incorrect';
		 echo $error;
		}
	}
	else{
		$error = "Veuillez remplir tous les champs ! ";
		echo $error;
	}
}


?>
<form action="login.php" method="POST">
	<input type="text" name="email"/>
	<input type="password" name="mdp"/>
	<button>Se connecter</button>
</form>
 </body>
</html>
