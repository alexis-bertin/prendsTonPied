<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start(); 
		//DEFINITION SESSION ID APRES INSCRIPTION
	$sessiondemerde = $_SESSION['email'];
	include_once('connexions.php');
	$sql69 = "SELECT DISTINCT id_Client FROM Client WHERE email = '".$sessiondemerde."'";
	try {
		$res69=$cx->query($sql69);	
		while ($tabl69=$res69->fetch(PDO::FETCH_ASSOC)) {
			$_SESSION['id'] = $tabl69['id_Client'];
		}
	}
	catch (PDOException $e) {
		echo "Erreur :".$e->getMessage()."<br/>";
		die();
	}
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
<html>
 <head>
	<title>COMPTE</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
 </head>
 <body>
 		<?php	

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
		$mail=$_POST['mail'];

		try {
			include("connexions.php");
			$sql="SELECT email FROM Client";
			$res=$cx->query($sql);
			while ($ligne=$res->fetch(PDO::FETCH_OBJ)) {
				$pseudo=$ligne->email;
				if ($pseudo == $mail) {
					$exist=true;
				}
			}
		}

		catch (PDOException $e) {
			echo "Erreur :".$e->getMessage()."<br/>";
			die();
		}

		//Si l'email rentré est dans la BDD
		if ($exist) {
			function generer_mot_de_passe($nb_caractere) {
		        $mot_de_passe = "";
		       
		        $chaine = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ023456789+@!$%?&";
		        $longeur_chaine = strlen($chaine);
		       
		        for ($i = 1; $i <= $nb_caractere; $i++) {
		            $place_aleatoire = mt_rand(0,($longeur_chaine-1));
		            $mot_de_passe .= $chaine[$place_aleatoire];
		        }

		        return $mot_de_passe;   
			}
			$nb_car=rand(8, 15);
			$mdppp=generer_mot_de_passe($nb_car);

			$EmailTo = $mail;
			$Subject = 'Réinitialisation de votre mot de passe';
					 
			//Prépare le texte du mail
			$Body .= "Bonjour,<br/> ";
			$Body .= "vous avez récemment demandé à réinitialiser votre mot de passe sur notre site.<br/><br/>";
			$Body .= "Voici vos nouvelles coordonnées :<br/>";
			$Body .= "Adresse mail : <b>".$mail."</b>";
			$Body .= "<br/>Mot de passe : <b>".$mdppp."</b>";
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

			//Changement mot de passe BDD
			include("connexions.php");
			try {
				$sql="UPDATE Client SET mdp = :mdp WHERE email = :mail";
				$prep=$cx->prepare($sql);
				$mdp2=Chiffrement::crypt($mdppp);
				$tabVal=array(':mdp'=>$mdp2, ':mail'=>$mail);
				$res=$prep->execute($tabVal);
			}
			catch (PDOException $e) {
				echo "Erreur :".$e->getMessage()."<br/>";
				die();
			}
			session_start(); 					
			$_SESSION['mail']=$mail;
			$_SESSION['mdp']=$mdp;
		}

		//Si l'email rentré n'est pas dans la BDD
		else {
			if ((filter_var($mail, FILTER_VALIDATE_EMAIL))) {
				$EmailTo = $mail;
				$Subject = 'Réinitialisation de votre mot de passe';
						 
				//Prépare le texte du mail
				$Body .= "Bonjour,<br/> ";
				$Body .= "vous avez récemment demandé à réinitialiser votre mot de passe sur notre site.<br/>";
				$Body .= "<br/>Toutefois, l'adresse que vous avez rentré ne correspond à aucun compte inscrit. Nous vous invitons à vous inscrire directement sur prendstonpied.fr.";
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
			}
			else {
				$message=true;
				include_once("reinMdp.php");
				die();
			}
		}

	?>

 		<div style="height: 5vw; background-color: lightgrey; margin-bottom: 2vw;">
			<?php
				echo "<input style=\"top: 2vw; left: 2vw; position: absolute;\" type=\"button\" value=\"Boutique\" onclick=\"window.location.href='../index.php'\" />";
				if (isset($_SESSION['email']))  {
					include_once('connexions.php');
					if (isset($_SESSION['id']) == FALSE) {
						$ididid = $_SESSION['id_Client'];
					}
					else {
						$ididid = $_SESSION['id'];
					}
					$_SESSION['lourd'] = $ididid;
					$sql = "SELECT DISTINCT nb_articles, total, frais_de_port, tab, id_Client FROM Panier WHERE Panier.id_Client = ".$ididid."";
					try {
						$res2=$cx->query($sql);
						$result = $res2->fetchAll(PDO::FETCH_ASSOC);
						if ((sizeof($result) != 0) || (sizeof($result) != NULL)) {
							$sql2 = "SELECT DISTINCT nb_articles, total, frais_de_port, tab, id_Client FROM Panier WHERE Panier.id_Client = ".$_SESSION['lourd']."";
							try {

							$res=$cx->query($sql2);	
							while ($tabl=$res->fetch(PDO::FETCH_ASSOC)) {
								$metallicalove = $tabl['nb_articles'];
								echo "<br/><div style=\"top: 2vw; right: 2vw; position: absolute;\"><form style=\"display: inline-block;\" method=\"POST\" action=\"search.php\" name=\"rechercher1\" role=\"search\"><input type=\"search\" id=\"maRecherche\" name=\"q\" placeholder=\"Rechercher\" size=\"30\"></form>";
								echo " ";
								echo "<input type=\"button\" value=\"Mon compte\" onclick=\"window.location.href='consultation.php'\" />";
								echo " ";

								if (($metallicalove == 0) || ($metallicalove == NULL)) {
									echo "<input type=\"button\" value=\"Mon panier\" onclick=\"window.location.href='panier.php'\" />";
								}
								else {
									echo "<input type=\"button\" value=\"Mon panier (".$metallicalove.")\" onclick=\"window.location.href='panier.php'\" />";
								}
								echo " ";
								echo "<input type=\"submit\" value=\"Se déconnecter\" onclick=\"window.location.href='deconnexion.php'\" /></div>";
							}
						}
					catch (PDOException $e) {
						echo "ERREUR :".$e->getMessage()."<br/>";
						die();
					}
				}
						else {
								echo "<br/><div style=\"top: 2vw; right: 2vw; position: absolute;\"><form style=\"display: inline-block;\" method=\"POST\" action=\"search.php\" name=\"rechercher1\" role=\"search\"><input type=\"search\" id=\"maRecherche\" name=\"q\" placeholder=\"Rechercher\" size=\"30\"></form>";
								echo " ";
								echo "<input type=\"button\" value=\"Mon compte\" onclick=\"window.location.href='consultation.php'\" />";
								echo " ";
									echo "<input type=\"button\" value=\"Mon panier\" onclick=\"window.location.href='panier.php'\" />";

								echo " ";
								echo "<input type=\"submit\" value=\"Se déconnecter\" onclick=\"window.location.href='deconnexion.php'\" /></div>";
						}
					}

					
					catch (PDOException $e) {
						echo "ERREUR :".$e->getMessage()."<br/>";
						die();
					}
				}				
				else {
							echo "<br/><div style=\"top: 2vw; right: 2vw; position: absolute;\"><form style=\"display: inline-block;\" method=\"POST\" action=\"search.php\" name=\"rechercher1\" role=\"search\"><input type=\"search\" id=\"maRecherche\" name=\"q\" placeholder=\"Rechercher\" size=\"30\"></form>";
							echo " ";
							echo "<input type=\"submit\" value=\"Connexion / Inscription\" onclick=\"window.location.href='accueil.php'\"  /></div>";
				}
			?>
		</div>
 	<h2>Votre demande de réinitialisation de mot de passe a été envoyé</h2>
 	<p style="max-width: 60vw;">Nous vous avons envoyé un e-mail avec les informations requises pour la réinitialisation de votre mot de passe à l'adresse indiquée. Veuillez vérifier vos courriers indésirables dans le cas où il aurait été envoyé dans les spam.</p>
	<br/><input type="button" value="Retourner sur le site" onclick="window.location.href='../index.php'" />		
 </body>
</html>