<?php 
	session_start(); 
	unset($_SESSION['ajout_chaussure']); 
	unset($_SESSION['yeahyeah']);
	unset($_SESSION['nom_haha']);
	unset($_SESSION['prenom_haha']);
	unset($_SESSION['cp_haha']);
	unset($_SESSION['ville_haha']);
	unset($_SESSION['norue_haha']);
	unset($_SESSION['nurue_haha']);
	unset($_SESSION['appart_haha']);
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
		<title>Prends ton pied - Commande</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<link href="slide/nouislider.css" rel="stylesheet">
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
			$id_Client_commande = $_SESSION['id_Client'];
			include_once('connexions.php');
			$sql2 = "SELECT nb_articles, total, frais_de_port, Panier.id_Client, tab FROM Panier JOIN Client ON Panier.id_Client = Client.id_Client WHERE Panier.id_Client = ".$id_Client_commande."";
			try {
				$res=$cx->query($sql2);
				while ($tabl=$res->fetch(PDO::FETCH_ASSOC)) {
					$tab_des_articles = unserialize($tabl['tab']);
					$_SESSION['yeahyeah'] = $tabl['id_Client'];
					$j=0;
					foreach ($tab_des_articles as $elt) {
						for ($i=0; $i < count($elt); $i++) { 
							${'elt'.$j.$i} = $elt[$i];
						}
						$j++;
					}
					//ENSEMBLE HAUT
					echo "<div style=\"display: inline-block;\">";

					echo "<div style=\"float: left; margin-left: 20vw; padding: 15px; background-color: lightgrey;\">";
					echo "<div style=\"padding: 10px; font-size: 22px; text-align: center;\">RÉCAPITULATIF</div>";
					echo "<div style=\"text-align: center; background-color: white;\">";
					for ($j=0; $j < count($tab_des_articles); $j++) {
						$mouimoui = ${'elt'.$j.'0'};
						include_once('connexions.php');
						$sqlsql = "SELECT DISTINCT img_chaussure, marque, modele, type_course, sexe, prix, id_chaussure, promotion FROM Chaussures WHERE id_chaussure = ".$mouimoui."";
						try {
							$res4=$cx->query($sqlsql);
							while ($tabll=$res4->fetch(PDO::FETCH_ASSOC)) {
								$y=0;
				 				foreach ($tabll as $elttt) {
				 					$elemmm[$y]=$elttt;
						 			$y++;
								}
								$newpri = $elemmm[5] - ($elemmm[5]*$elemmm[7]/100);
								$newprix = sprintf("%01.2f", $newpri);
								echo "<div style=\"padding: 20px;\">";
								//Ligne 1 (quantite+marque+modele)
								echo "<div style=\"text-align: left;\">".${'elt'.$j.'2'}." x ".$elemmm[1]." ".$elemmm[2]."</div>";
								//Ligne 2 (pointure)
								echo "<div style=\"text-align: left; margin-left: 10px;\">(Pointure : ".${'elt'.$j.'1'}.")</div>";
								//Ligne 3 (prix)
								echo "<div style=\"text-align: right;\">".sprintf("%01.2f",($newprix*${'elt'.$j.'2'}))."€</div>";
								echo "</div>";
							}
						}
						catch (PDOException $e) {
							echo "ERREUR :".$e->getMessage()."<br/>";
							die();
						}
					}
					echo "<div style=\"padding: 20px;\"> <div style=\"text-align: left;\">Frais de livraison</div> <div style=\"text-align: right;\">".sprintf("%01.2f",$tabl['frais_de_port'])."€</div> </div>";
					echo "</div>";
					echo "<div style=\"text-align: center; background-color: grey; padding: 10px; color: white; font-size: 18px; font-weight: bolder;\">";
					echo "<div style=\"text-align: left; float: left;\">TOTAL</div>";
					echo "<div style=\"text-align: right;\">".sprintf("%01.2f",(($tabl['total'])+sprintf("%01.2f",$tabl['frais_de_port'])))."€</div>";
					echo "</div>";
					echo "</div>";
				}
			}
			catch (PDOException $e) {
				echo "ERREUR :".$e->getMessage()."<br/>";
				die();
			}
			echo "<div style=\"float: left; margin-left: 8vw; padding: 15px; background-color: lightgrey;\">";
			if (isset($message_coord)) { 
				echo "<div style=\"text-align: center; background-color: #FA5858; color: white; border: 1px black solid; padding:5px;\"><div> Veuillez remplir les champs obligatoires et respecter leur syntaxe </div></div>";
			}
			echo "<div style=\"padding: 10px; font-size: 22px; text-align: center;\">LIVRAISON</div>";
			echo "<div style=\"text-align: center; background-color: white; padding: 10px;\">";
			try {
 				$log=$_SESSION['email'];
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

					$_SESSION['nom_haha']=$nom;
					$_SESSION['prenom_haha']=$prenom;

					echo "<form style=\"margin-bottom:16px;\" name=\"envoiCoor\" method=\"POST\" action=\"envoiCommande.php\">";
					echo "<table>
							<tr><td>Nom* : </td><td><input name=\"nom\" type=\"text\" value=".$nom."></input></td></tr>
							<tr><td>Prénom* : </td><td><input name=\"prenom\" type=\"text\" value=".$prenom."></input></td></tr>
							<tr><td>Adresse mail* : </td><td><input name=\"email\" type=\"text\" value=".$email."></input></td></tr>
							<tr><td>Téléphone* : </td><td><input name=\"tel\" type=\"text\" value=".$tel."></input></td></tr>
							<tr><td>Code postal* : </td><td><input name=\"cp\" type=\"text\" value=".$cp."></input></td></tr>
							<tr><td>Ville* : </td><td><input name=\"ville\" type=\"text\" value=\"".$ville."\"></input></td></tr>
							<tr><td>N° rue : </td><td><input name=\"nurue\" type=\"text\" value=\"".caseVide($nurue)."\"></input></td></tr>
							<tr><td>Rue* : </td><td><input name=\"norue\" type=\"text\" value=\"".$norue."\"></input></td></tr>
							<tr><td>N° appartement : </td><td><input name=\"appart\" type=\"text\" value=".caseVide($appart)."></input></td></tr></table>";
				}
			}
			catch (PDOException $e) {
				echo "ERREUR :".$e->getMessage()."<br/>";
				die();
			}
			echo "</div>";
			echo "</div>";
			//FIN ENSEMBLE HAUT
			echo "</div>";

			//DEBUT ENSEMBLE BAS 
			echo "<div style=\"padding: 20px; background-color: lightgrey; margin-bottom: 1vw; margin-top: 5vw; display: list-item;\">";
			echo "<div style=\"float: right; text-align: right;\"><input style=\" background-color: green; color: white;\" type=\"submit\" value=\"Passer la commande\" /></div>";			
			echo "</form>";
			echo "<div style=\" float: left; text-align: left;\"><input style=\"\" type=\"submit\" value=\"Retourner au panier\" onclick=\"window.location.href='panier.php'\" /></div>";		
			echo "</div>";		
		?>
	</body>
</html>