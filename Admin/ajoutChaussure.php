<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start(); 
?>
<?php
	function VerifSaisie() {
		if (isset ($_POST['obli'])) {
				$tab=$_POST['obli'];
				if (is_array ($tab)) {
					foreach ($tab as $cle => $val) {
						if (empty ($val)) {
							$GLOBALS['msgErreur']=$cle." non renseigné";
							return false;
						}
					}
					return true;
				}
				return false;
		}
		return false;
	}
	/*class Chiffrement {
		// Algorithme utilisé pour le cryptage des blocs
		private static $cipher  = MCRYPT_RIJNDAEL_128;
		// Clé de cryptage         
		private static $key = "cledelamortquitue";
		// Mode opératoire (traitement des blocs)
		private static $mode = 'cbc';
		public static function crypt($data){
		    $keyHash = md5(self::$key);
		    $key = substr($keyHash, 0, mcrypt_get_key_size(self::$cipher, self::$mode));
		    $iv  = substr($keyHash, 0, mcrypt_get_block_size(self::$cipher, self::$mode));
		    $data = mcrypt_encrypt(self::$cipher, $key, $data, self::$mode, $iv);
		    return base64_encode($data);
		}
		public static function decrypt($data){
		    $keyHash = md5(self::$key);
		    $key = substr($keyHash, 0,   mcrypt_get_key_size(self::$cipher, self::$mode) );
		    $iv  = substr($keyHash, 0, mcrypt_get_block_size(self::$cipher, self::$mode) );
		    $data = base64_decode($data);
		    $data = mcrypt_decrypt(self::$cipher, $key, $data, self::$mode, $iv);
		    return rtrim($data);
		}
	}*/

	$exist=false;
	$tabl=$_POST['obli'];
	try {
		include("connexions.php");
		$sql="SELECT email FROM Client";
		$res=$cx->query($sql);
		while ($ligne=$res->fetch(PDO::FETCH_OBJ)) {
			$pseudo=$ligne->email;
			if ($pseudo == $tabl['email']) {
				$exist=true;
			}
		}
	}
	catch (PDOException $e) {
		echo "Erreur :".$e->getMessage()."<br/>";
		die();
	}
	$date= setlocale (LC_TIME, 'fr_FR'); print strftime("%A %d %B %Y"); 
	if (!$exist) {
		if (VerifSaisie()) {
			include("connexions.php");
			$nom=$tabl['nom']; 
			$prenom=$tabl['prenom'];
			$sexe=$_POST['sexe'];
			$date_naissance=$_POST['date_naissance'];
			$tel=$_POST['tel'];
			$cp=$_POST['cp']; 
			$ville=$_POST['ville']; 
			$norue=$_POST['norue']; 
			$nurue=$_POST['nurue']; 
			$appart=$_POST['appart'];  
			$email=$tabl['email']; 
			$mdp=$tabl['mdp'];
			$email2=$tabl['email2']; 
			$mdp2=$tabl['mdp2'];
			if ((preg_match("/^\pL+(?>[- ']\pL+)*$/u", $nom)) && (preg_match("/^\pL+(?>[- ']\pL+)*$/u", $prenom)) && (filter_var($email, FILTER_VALIDATE_EMAIL)) && ((strlen($mdp) >= 8) && (preg_match('#^(?=.*[a-z])(?=.*[0-9])(?=.*\W)#', $mdp)))) {
				if ($email==$email2 && $mdp==$mdp2) {
					$mdpc = Chiffrement::crypt($mdp);
					try {
						$sql="INSERT INTO  Client VALUES (NULL, :nom, :prenom, :sexe, :email, :mdp, :tel,:date_depot, :code_postal, :ville, :nom_rue, :num_rue, :num_appart)";
						$prep=$cx->prepare($sql);
						$tabVal=array(':nom'=>$nom, ':prenom'=>$prenom, ':sexe'=>$sexe, ':email'=>$email, ':mdp'=>$mdpc, ':tel'=>$tel, ':date_depot'=>$date ':code_postal'=>$cp, ':ville'=>$ville, ':nom_rue'=>$norue, ':num_rue'=>$nurue, ':num_appart'=>$appart, );
						$res=$prep->execute($tabVal);
					}
					catch (PDOException $e) {
						echo "Erreur :".$e->getMessage()."<br/>";
						die();
					}
					$EmailTo = $email;
					$Subject = 'Inscription réussie';
							 
					//Prépare le texte du mail
					$Body .= "Bonjour,<br/> ";
					$Body .= "vous vous êtes récemment inscrit sur notre site. Nous vous remercions pour votre intérêt porté sur les produits que nous proposons.<br/><br/>";
					$Body .= "Voici vos coordonnées :<br/>";
					$Body .= "Adresse mail : <b>".$email."</b>";
					$Body .= "<br/>Mot de passe : <b>".$mdp."</b>";
					$Body .= "<br/><br/>Conservez bien votre mot de passe qui vous sert à accéder à votre compte client sur prendstonpied.fr. Vous pouvez le modifier directement sur votre compte.";
					$Body .= "<br/><br/>Toute l'équipe vous salue,<br/>";
					$Body .= "PRENDS TON PIED";
					$Body .= "\n";

					$headers ='From: "Prends ton pied"<prendstonpied@gmail.com>'."\n"; 
					$headers .='Reply-To: prendstonpied@gmail.com'."\n"; 
					$headers .='Content-Type: text/html; charset=iso-8859-1' ."\r\n"; 
					$headers .='Content-Transfer-Encoding: 8bit'; 

					$success = "";
							 
					//Envoie le mail
					$success = mail($EmailTo, utf8_decode($Subject), utf8_decode($Body), $headers);
					session_start();
					$_SESSION['nom']=$tabl['nom'];
					$_SESSION['prenom']=$tabl['prenom'];
			 		$_SESSION['cp']=$_POST['cp'];
			 		$_SESSION['ville']=$_POST['ville'];
			 		$_SESSION['sexe']=$_POST['sexe'];
					$_SESSION['norue']=$_POST['norue'];
					$_SESSION['nurue']=$_POST['nurue'];
					$_SESSION['appart']=$_POST['appart'];
			 		$_SESSION['tel']=$_POST['tel'];
			 		$_SESSION['date_naissance']=$_POST['date_naissance'];
			 		$_SESSION['email']=$tabl['email']; 
			 		$_SESSION['mdp']=$tabl['mdp'];
			 		$_SESSION['mdpc']=$mdpc;
					header("location: consultation.php");
				}
				else if ($email != $email2) {
					$message3=true;
					include_once("inscription.php");
				}
				else if ($mdp != $mdp2) {
					$message4=true;
					include_once("inscription.php");
				}
			}
			else if (((preg_match("/^\pL+(?>[- ']\pL+)*$/u", $nom)) == FALSE) || ((preg_match("/^\pL+(?>[- ']\pL+)*$/u", $prenom)) == FALSE) || ((filter_var($email, FILTER_VALIDATE_EMAIL)) == FALSE) || (((strlen($mdp) >= 8) == FALSE) || ((preg_match('#^(?=.*[a-z])(?=.*[0-9])(?=.*\W)#', $mdp)) == FALSE))) {
				if ((preg_match("/^\pL+(?>[- ']\pL+)*$/u", $nom)) == FALSE) {
					$message5=true;
				}
				if ((preg_match("/^\pL+(?>[- ']\pL+)*$/u", $prenom)) == FALSE) {
					$message6=true;
				}
				if ((filter_var($email, FILTER_VALIDATE_EMAIL)) == FALSE) {
					$message7=true;
				}
				if (((strlen($mdp) >= 8) == FALSE) || ((preg_match('#^(?=.*[a-z])(?=.*[0-9])(?=.*\W)#', $mdp)) == FALSE)) {
					$message8=true;
				}
				include_once("inscription.php");
			}
		}
		else {
			$message=true;
			include_once("inscription.php");
		}
	}
	else {
		$message2=true;
		include_once("inscription.php");
	}
?>