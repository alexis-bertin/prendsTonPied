<?php 
session_start(); 
//Si le cookie existe, créer la connexion automatique
  if (isset($_COOKIE['auto_prendstonpied'])) {
      include("connexions.php");
    $email=$_COOKIE['auto_prendstonpied'];
    $sql="SELECT * FROM Client WHERE email='$email'";
    $res=$cx->query($sql);
    while ($ligne=$res->fetch(PDO::FETCH_OBJ)) {
      $mail=$ligne->email;
      $mdp=$ligne->mdp;
      $nom=$ligne->nom;
      $prenom=$ligne->prenom;
      $cp2=$ligne->code_postal;
      $ville=$ligne->ville;
      $norue2=$ligne->nom_rue;
      $nurue2=$ligne->num_rue;
      $appart2=$ligne->num_appart;
      $tel=$ligne->tel;
      $id=$ligne->id_Client;
      if ($id==1) {
        $_SESSION['connect']=3;
      }
    }
    setcookie('auto_prendstonpied', $mail, time() + 24*3600, '/', null, false, true);
    setcookie('id_prendstonpied', $id, time() + 24*3600, '/', null, false, true);
    setcookie('mdp_prendstonpied', $mdp, time() + 24*3600, '/', null, false, true);
    setcookie('nom_prendstonpied', $nom, time() + 24*3600, '/', null, false, true);
    setcookie('prenom_prendstonpied', $prenom, time() + 24*3600, '/', null, false, true);
    setcookie('cp_prendstonpied', $cp2, time() + 24*3600, '/', null, false, true);
    setcookie('ville_prendstonpied', $ville, time() + 24*3600, '/', null, false, true);
    setcookie('norue_prendstonpied', $norue2, time() + 24*3600, '/', null, false, true);
    setcookie('nurue_prendstonpied', $nurue2, time() + 24*3600, '/', null, false, true);
    setcookie('appart_prendstonpied', $appart2, time() + 24*3600, '/', null, false, true);
    setcookie('tel_prendstonpied', $tel, time() + 24*3600, '/', null, false, true);

    $_SESSION['email']=$_COOKIE['auto_prendstonpied'];
    $_SESSION['id_Client']=$_COOKIE['id_prendstonpied'];
    $_SESSION['mdp']=$_COOKIE['mdp_prendstonpied'];
      $_SESSION['nom']=$_COOKIE['nom_prendstonpied'];
    $_SESSION['prenom']=$_COOKIE['prenom_prendstonpied'];
    $_SESSION['ville']=$_COOKIE['ville_prendstonpied'];
    $_SESSION['tel']=$_COOKIE['tel_prendstonpied'];
    $_SESSION['cp']=$_COOKIE['cp_prendstonpied'];
    $_SESSION['norue']=$_COOKIE['norue_prendstonpied'];
    $_SESSION['nurue']=$_COOKIE['nurue_prendstonpied'];
    $_SESSION['appart']=$_COOKIE['appart_prendstonpied'];
    }
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

//////////////////////////////////////////////////////////////////////////////////////

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

/////////////////////////////////////////////////////////////////////////////////////////////	

	$exist=false;
	$tabl=$_POST['obli'];
	try {
		include("connexions.php");
		$sql="SELECT mdp FROM Client";
		$res=$cx->query($sql);
		while ($ligne=$res->fetch(PDO::FETCH_OBJ)) {
			$pseudo=$ligne->mdp;
			$mdpc=Chiffrement::decrypt($pseudo);
			if ($mdpc == $tabl['ancien']) {
				$exist=true;
			}
		}
	}
	catch (PDOException $e) {
		echo "Erreur :".$e->getMessage()."<br/>";
		die();
	}
	if ($exist) {
		if (VerifSaisie()) {
			include("connexions.php");
			$ancien=$tabl['ancien'];
			$new=$tabl['new'];
			$new2=$tabl['new2'];
			$id=$_SESSION['id'];
			if (((strlen($new) >= 8) && (preg_match('#^(?=.*[a-z])(?=.*[0-9])(?=.*\W)#', $new))) && ((strlen($new2) >= 8) && (preg_match('#^(?=.*[a-z])(?=.*[0-9])(?=.*\W)#', $new2)))) {
				if ($new==$new2) {
					try {
						$sql="UPDATE Client SET mdp = :mdp WHERE id_Client = :id";
						$prep=$cx->prepare($sql);
						$neww=Chiffrement::crypt($new);
						$tabVal=array(':mdp'=>$neww, ':id'=>$id);
						$res=$prep->execute($tabVal);
					}
					catch (PDOException $e) {
						echo "Erreur :".$e->getMessage()."<br/>";
						die();
					}
					session_start(); 					
					$_SESSION['id_Client']=$id;
			 		$_SESSION['mdp']=$tabl['new'];
			 		$_SESSION['message3']=true;
					header("location: modifMdp.php");
				}
				else if ($new != $new2) {
					$message2=true;
					include_once("modifMdp.php");
				}
			}
			else if ((((strlen($new) >= 8) == FALSE) || ((preg_match('#^(?=.*[a-z])(?=.*[0-9])(?=.*\W)#', $new))) == FALSE) || (((strlen($new2) >= 8) == FALSE) || ((preg_match('#^(?=.*[a-z])(?=.*[0-9])(?=.*\W)#', $new2))) == FALSE)) {
				if ((((strlen($new) >= 8) == FALSE) || ((preg_match('#^(?=.*[a-z])(?=.*[0-9])(?=.*\W)#', $new))) == FALSE)) {
					$message5=true;
				}
				include_once("modifMdp.php");
			}
		}
		else {
			$message4=true;
			include_once("modifMdp.php");
		}
	}
	else {
		$message=true;
		include_once("modifMdp.php");
	}
?>