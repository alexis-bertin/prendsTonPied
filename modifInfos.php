<?php
	session_start(); 
?>
<?php
			$nom=$_POST['nom']; 
			$prenom=$_POST['prenom'];
			$tel=$_POST['tel'];
			$cp=$_POST['cp']; 
			$ville=$_POST['ville']; 
			$norue=$_POST['norue']; 
			$nurue=$_POST['nurue']; 
			$appart=$_POST['appart'];  
			$email=$_POST['email']; 
			$id=$_SESSION['id_Client'];
			if ((preg_match("/^\pL+(?>[- ']\pL+)*$/u", $nom)) && (preg_match("/^\pL+(?>[- ']\pL+)*$/u", $prenom)) && (filter_var($email, FILTER_VALIDATE_EMAIL)) && (((strlen($tel)==10) && (ctype_digit($tel))) || empty($tel)) && (((strlen($cp)==5) && (ctype_digit($cp))) || empty($cp)) && ((preg_match("/^\pL+(?>[- ']\pL+)*$/u", $ville)) || empty($ville)) && ((preg_match("/^\pL+(?>[- ']\pL+)*$/u", $norue)) || empty($norue)) && ((ctype_digit($nurue)) || empty($nurue)) && ((ctype_digit($appart)) || empty($appart))) {
					try {
						include_once("connexions.php");
						$sql="UPDATE Client SET nom = :nom, prenom = :prenom, tel = :tel, code_postal = :cp, ville = :ville, nom_rue = :norue, num_rue = :nurue, num_appart = :appart, email = :email WHERE id_Client = :id";
						$prep=$cx->prepare($sql);
						$tabVal=array(':nom'=>$nom, ':prenom'=>$prenom, ':email'=>$email, ':tel'=>$tel, ':cp'=>$cp, ':ville'=>$ville, ':norue'=>$norue, ':nurue'=>$nurue, ':appart'=>$appart, ':id'=>$id);
						$res=$prep->execute($tabVal);
					}
					catch (PDOException $e) {
						echo "Erreur :".$e->getMessage()."<br/>";
						die();
					}
					session_start();
					$_SESSION['id_Client']=$id;
					$_SESSION['nom']=$_POST['nom'];
					$_SESSION['prenom']=$_POST['prenom'];
			 		$_SESSION['cp']=$_POST['cp'];
			 		$_SESSION['ville']=$_POST['ville'];
					$_SESSION['norue']=$_POST['norue'];
					$_SESSION['nurue']=$_POST['nurue'];
					$_SESSION['appart']=$_POST['appart'];
			 		$_SESSION['tel']=$_POST['tel'];
			 		$_SESSION['email']=$_POST['email'];
			 		if (isset($_COOKIE['auto_prendstonpied'])) {
			 			setcookie('auto_prendstonpied', $_SESSION['email'], time() + 24*3600, '/', null, false, true);
						setcookie('id_prendstonpied', $_SESSION['id_Client'], time() + 24*3600, '/', null, false, true);
						setcookie('nom_prendstonpied', $_SESSION['nom'], time() + 24*3600, '/', null, false, true);
						setcookie('prenom_prendstonpied', $_SESSION['prenom'], time() + 24*3600, '/', null, false, true);
						setcookie('cp_prendstonpied', $_SESSION['cp'], time() + 24*3600, '/', null, false, true);
						setcookie('ville_prendstonpied', $_SESSION['ville'], time() + 24*3600, '/', null, false, true);
						setcookie('norue_prendstonpied', $_SESSION['norue'], time() + 24*3600, '/', null, false, true);
						setcookie('nurue_prendstonpied', $_SESSION['nurue'], time() + 24*3600, '/', null, false, true);
						setcookie('appart_prendstonpied', $_SESSION['appart'], time() + 24*3600, '/', null, false, true);
						setcookie('tel_prendstonpied', $_SESSION['tel'], time() + 24*3600, '/', null, false, true);
			 		}	
					header("location: consultation.php");
					exit();
			}
			else {
				$message1=true;
				include_once("consultation.php");
			}
?>