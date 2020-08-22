<?php 
	session_start();
	include("connexions.php");
	$email=$_POST['email'];
	$mdp=$_POST['mdp'];
	$connect=0;
	try {
		$sql="SELECT id_Client,email, mdp FROM Client WHERE email='$email'";
		$res=$cx->query($sql);
		while ($ligne=$res->fetch(PDO::FETCH_OBJ)) {
			$log=$ligne->email;
			$pass=$ligne->mdp;
			$mdpc = Chiffrement::decrypt($pass);
			$id=$ligne->id_Client;
			if ($email == $log && $mdp == $mdpc && $email !== NULL) {
				$mail_cookie=$_POST['email'];
				if ($_POST['souvenir'] == '') {
					setcookie('mail_prendstonpied','',time());
				}
				else if (($_POST['souvenir'] == "on") && (filter_var($mail_cookie, FILTER_VALIDATE_EMAIL))) {
					setcookie('mail_prendstonpied', $mail_cookie, time() + 30*24*3600, null, null, false, true); 
				}

				///////////////////// GESTION COOKIE CONNEXION AUTOMATIQUE //////////////////////////////////////

				if (isset($_POST['stay_c'])) {
					$mail2_cookie=$_POST['email'];
					setcookie('auto_prendstonpied', $mail2_cookie, time() + 24*3600, '/', null, false, true);
				}
			}
		}
	}
	catch (PDOException $e) {
		echo "Erreur :".$e->getMessage()."<br/>";
		die();
	}
		class Chiffrement {
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
		}
		if (isset($_POST['Inscription'])) {
			include_once("inscription.php");
			header ("location: inscription.php");
		}
		else {
			if (isset($_POST['email']) && $_POST['email']!="") {//On vérifie s'il y a bien un login 
				include("connexions.php");
				$email=$_POST['email'];
				$mdp=$_POST['mdp'];
				$connect=0;
				try {
					$sql="SELECT id_Client,email, mdp FROM Client WHERE email='$email'";
					$res=$cx->query($sql);
					while ($ligne=$res->fetch(PDO::FETCH_OBJ)) {
						$log=$ligne->email;
						$pass=$ligne->mdp;
						$mdpc = Chiffrement::decrypt($pass);
						$id=$ligne->id_Client;
						if ($email == $log && $mdp == $mdpc) {
							if ($id==1) {
								$connect=3;
								session_start();
								$_SESSION['connect']=3;
				 				$_SESSION['email']=$email;
				 				$_SESSION['mdp']=$mdp;
				 				$_SESSION['id']=$id;
							}
							else {
								$connect=1;
								session_start();
				 				$_SESSION['email']=$email;
				 				$_SESSION['mdp']=$mdp;
				 				$_SESSION['id']=$id;
				 			}
			 			}
			 			else if ($email != $log || $mdp != $mdpc) {
			 				$connect=2;
			 			}
					}
				}
				catch (PDOException $e) {
					echo "Erreur :".$e->getMessage()."<br/>";
					die();
				}
				if ($connect==1) {
					include_once("consultation.php");
					header("location: consultation.php");
					die();
				}
				if ($connect==2) {
					include_once("accueil.php");
					header ("location: accueil.php");
					die();
				}
				if ($connect==3) {
					include_once("consultation.php");
					header("location: consultation.php");
					die();
				}
				$okMdp=true;
			}
			else 
				$okMdp2=true;
				include_once("accueil.php");
				header ("location: accueil.php");
		}
	?>
