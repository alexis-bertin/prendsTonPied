<?php 
	session_start();
	unset($_SESSION['nomzbeub']);
    unset($_SESSION['id_Clientzbeub']);
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
 </head>
 <body>
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
 	<?php
 		function caseVide ($info) {
 			if (empty ($info)) {
 				$info = "";
 				return $info;
 			}
 			else
 				return $info;
 		}
 		function appartVide($appart) {
 			if (empty ($appart)) {
 				$appart = "";
 				return $appart;
 			}
 			else
 				$appart = "<em>appart n°</em>".$appart;
 				return $appart;
 		}
 		include ("connexions.php");
 		if (isset($_SESSION['nom'])) {
 			extract($_SESSION);
 			echo "<p><h2>INFO COMPTE</h2></p>";
 			if (isset($message1)) { 
				echo "<span class='alert'>Champ(s) incorrect(s)</span>";
			}
 			echo "<form method=\"POST\" action=\"modifInfos.php\">";
			echo "<br/><table>
							<tr><td>Nom : </td><td><input name=\"nom\" type=\"text\" value=".caseVide($nom)."></input></td></tr>
							<tr><td>Prénom : </td><td><input name=\"prenom\" type=\"text\" value=".caseVide($prenom)."></input></td></tr>
							<tr><td>Adresse mail : </td><td><input name=\"email\" type=\"text\" value=".caseVide($email)."></input></td></tr>
							<tr><td>Téléphone : </td><td><input name=\"tel\" type=\"text\" value=".caseVide($tel)."></input></td></tr>
							<tr><td>Code postal : </td><td><input name=\"cp\" type=\"text\" value=".caseVide($cp)."></input></td></tr>
							<tr><td>Ville : </td><td><input name=\"ville\" type=\"text\" value=\"".caseVide($ville)."\"></input></td></tr>
							<tr><td>N° rue : </td><td><input name=\"nurue\" type=\"text\" value=".caseVide($nurue)."></input></td></tr>
							<tr><td>Rue : </td><td><input name=\"norue\" type=\"text\" value=\"".caseVide($norue)."\"></input></td></tr>
							<tr><td>N° appartement : </td><td><input name=\"appart\" type=\"text\" value=".caseVide($appart)."></input></td></tr></table>";
 		}
 		else {
 			try {
 				include_once("consultation.php");
 				$_SESSION['email']=$log;
				$sql="SELECT * FROM Client WHERE email ='$log'";
				$prep=$cx->prepare($sql);
				$tabVal=array(':log'=>$log);
				$res=$prep->execute($tabVal);
				while ($ligne=$prep->fetch(PDO::FETCH_OBJ)) {
					$id=$ligne->id_Client;
					$nom=$ligne->nom;
					$prenom=$ligne->prenom;
					$email=$ligne->email;
					$tel=$ligne->tel;
					$cp=$ligne->code_postal;
					$ville=$ligne->ville;
					$norue=$ligne->nom_rue;
					$nurue=$ligne->num_rue;
					$appart=$ligne->num_appart;
					echo "<p><h2>INFO COMPTE</h2></p>";
					echo "<form style=\"margin-bottom:16px;\" name=\"modif\" method=\"POST\" action=\"modifInfos.php\">";
					echo "<table>
							<tr><td>Nom : </td><td><input name=\"nom\" type=\"text\" value=".$nom."></input></td></tr>
							<tr><td>Prénom : </td><td><input name=\"prenom\" type=\"text\" value=".caseVide($prenom)."></input></td></tr>
							<tr><td>Adresse mail : </td><td><input name=\"email\" type=\"text\" value=".caseVide($email)."></input></td></tr>
							<tr><td>Téléphone : </td><td><input name=\"tel\" type=\"text\" value=".caseVide($tel)."></input></td></tr>
							<tr><td>Code postal : </td><td><input name=\"cp\" type=\"text\" value=".caseVide($cp)."></input></td></tr>
							<tr><td>Ville : </td><td><input name=\"ville\" type=\"text\" value=\"".caseVide($ville)."\"></input></td></tr>
							<tr><td>N° rue : </td><td><input name=\"nurue\" type=\"text\" value=".caseVide($nurue)."></input></td></tr>
							<tr><td>Rue : </td><td><input name=\"norue\" type=\"text\" value=\"".caseVide($norue)."\"></input></td></tr>
							<tr><td>N° appartement : </td><td><input name=\"appart\" type=\"text\" value=".caseVide($appart)."></input></td></tr></table>";
				}

			}
			catch (PDOException $e) {
				echo "Erreur :".$e->getMessage()."<br/>";
				die();
			}

 		}
 		$_SESSION['id_Clientzbeub']=$id;
 		$_SESSION['nomzbeub']=$nom; 		
 		$_SESSION['id_Client']=$id;
 		$_SESSION['nom']=$nom;
 		$_SESSION['prenom']=$prenom;
 		$_SESSION['email']=$email;
 		$_SESSION['tel']=$tel;
 		$_SESSION['cp']=$cp;
 		$_SESSION['ville']=$ville;
 		$_SESSION['norue']=$norue;
 		$_SESSION['nurue']=$nurue;
 		$_SESSION['appart']=$appart;

 		echo "<br/><input style=\"\" type=\"submit\" value=\"Sauvegarder les informations\" />";
 		echo "</form>";
 		echo "   ";
 		if ($_SESSION['connect']==3) { 
			echo "<input style=\"\" type=\"submit\" value=\"Accéder à l'interface admin\" onclick=\"window.location.href='interface.php'\"/>";
			echo "   ";
		}
 		echo "<input style=\"\" type=\"button\" value=\"Changer mot de passe\" onclick=\"window.location.href='modifMdp.php'\" />";
 		echo "   ";
 		echo "<input style=\"\" type=\"button\" value=\"Se désinscrire\" onclick=\"window.location.href='desinscription.php' \" />";
 	?>	
 </body>
</html>