<?php 
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
		<title>Prends ton pied - Page produit</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript">
					function checkedd() {
						$('#crit2').prop('checked', false); 
						$('#crit3').prop('checked', false); 
						return false;
					}
					function checkedd2() {
						$('#crit1').prop('checked', false);
						$('#crit3').prop('checked', false); 
						return false;
					}
					function checkedd3() {
						$('#crit1').prop('checked', false);
						$('#crit2').prop('checked', false); 
						return false;
					}
			</script>
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
		 	if (isset($prob_co)) { 
				echo "<div style=\"text-align: center; background-color: #FA5858; color: white; border: 1px black solid; padding:10px;\"><div> Veuillez vous connecter pour ajouter un article au panier </div><br/>";
				echo "<input type=\"submit\" value=\"Se connecter\" onclick=\"window.location.href='accueil.php'\"  /></div>";
			}
			if (isset($prob_point)) { 
				echo "<div style=\"text-align: center; background-color: #FA5858; color: white; border: 1px black solid; padding:10px;\"><div> Veuillez sélectionner une pointure avant d'ajouter à votre panier </div></div>";
			}
			if (isset($ajout_effectue)) { 
				echo "<div style=\"text-align: center; background-color: #3ADF00; color: white; border: 1px black solid; padding:10px;\"><div>".$nb_effectue." article(s) ajouté(s) à votre panier</div></div>";
			}

			if (isset($_SESSION['ajout_chaussure'])) {
				$id_chauss = $_SESSION['ajout_chaussure'];
			}
			else {
				$id_chauss = $_GET['iddd'];
				$_SESSION['ajout_chaussure']=$id_chauss;
			}
			$_SESSION['ajout_chaussure']=$id_chauss;
			include_once('connexions.php');
			$sql = "SELECT DISTINCT img_chaussure,marque,modele,prix,promotion,Chaussures.id_chaussure FROM Chaussures JOIN Stock ON Chaussures.id_Chaussure = Stock.id_chaussure WHERE Chaussures.id_chaussure = ".$id_chauss."";
			try {
				$res=$cx->query($sql);
				//Structuration du tableau
				echo "<div style=\"text-align: center; width: 100%;\">";
				while ($tabl=$res->fetch(PDO::FETCH_ASSOC)) {
					$i=0;
 					foreach ($tabl as $elt) {
 						$elem[$i]=$elt;
			 			$i++;
					}
					echo "<div style=\" text-align: center; display: inline-block; margin: 15px; padding: 10px; vertical-align:middle;\"><div style=\"float: left; margin-right: 10vw;\">";
					if ($elem[4] != 0) {
						echo "<div style=\"position: absolute; padding: 5px; color: white; background-color: red; \">".$elem[4]."%</div>";
						$newpri = $elem[3] - ($elem[3]*$elem[4]/100);
						$newprix = sprintf("%01.2f", $newpri);
					}
					echo "<img src = .".$elem[0]." style=\"width:30vw;height:30vw;\"></div>";
					echo "<div style=\"float: left; text-align: left;\"><b><div style=\"margin-top:10px; font-size: 40px;\">".$elem[1]." ".$elem[2]."</div></b>";
					if ($elem[4] != 0) {
						echo "<div style=\"margin-top:10px; text-align: right;\">".$newprix."€ <strike>".$elem[3]."€</strike></div>";
					}
					else {
						echo "<div style=\"margin-top:10px; text-align: right;\">".$elem[3]."€</div>";
					}
				} 

				/*////////// DEBUT DU FORM //////////*/

				include_once('connexions.php');
				$sqlzbeub="SELECT DISTINCT Stock FROM Stock JOIN Chaussures ON Stock.id_Chaussure = Chaussures.id_Chaussure WHERE Chaussures.id_chaussure = ".$id_chauss."";
				try {
					$reszbeub=$cx->query($sqlzbeub);
					while ($lignezbeub=$reszbeub->fetch(PDO::FETCH_ASSOC)) {
						if ($lignezbeub['Stock'] != 0) {
							$verification += 1;
						}
						else {
							$verification += 0;
						}
					}
					if ($verification == 0) {
						echo "<div style=\"color: red; font-size: 25px; padding-top: 3vw; padding-right: 2vw; text-align: right;\"> Rupture de stock </div></div>";
					}
					else {
						echo "<form method=\"POST\" action=\"ajout_panier.php\" name=\"test10\" >";
						include_once('connexions.php');
						$sql3="SELECT DISTINCT pointure FROM Stock JOIN Chaussures ON Stock.id_Chaussure = Chaussures.id_Chaussure WHERE Chaussures.id_chaussure = ".$id_chauss."";
						try {
							$res3=$cx->query($sql3);
							echo "<h3 style=\"margin-bottom: 4px; \">Pointure</h3>";
							//Mise en place des lignes comprenant les données de la BDD
							while ($ligne=$res3->fetch(PDO::FETCH_ASSOC)) {
								include_once('connexions.php');
								$sqlz="SELECT DISTINCT Stock FROM Stock JOIN Chaussures ON Stock.id_Chaussure = Chaussures.id_Chaussure WHERE Stock.pointure = ".$ligne['pointure']." && Chaussures.id_chaussure = ".$id_chauss."";
								try {
									$resz=$cx->query($sqlz);
									while ($lignez=$resz->fetch(PDO::FETCH_ASSOC)) {
										if ($lignez['Stock'] != 0) {
											$verifStock = 1;
										}
										else {
											$verifStock = 0;
										}
									}
								}
								catch (PDOException $e) {
									echo "ERREUR :".$e->getMessage()."<br/>";
									die();
								}
								if ($verifStock == 1) {
									echo "<input type=\"radio\" name=pointure_p value=".$ligne['pointure'].">".$ligne['pointure'];
								}
							}
						}
						catch (PDOException $e) {
							echo "ERREUR :".$e->getMessage()."<br/>";
							die();
						}
						echo "<h3 style=\"margin-bottom: 4px; \">Quantité</h3>";
						include_once('connexions.php');
						$sqlmoui="SELECT MIN(Stock) FROM Stock JOIN Chaussures ON Stock.id_Chaussure = Chaussures.id_Chaussure WHERE Chaussures.id_chaussure = ".$id_chauss." && Stock.Stock != 0";
						try {
							$resmoui=$cx->query($sqlmoui);
							while ($lignemoui=$resmoui->fetch(PDO::FETCH_ASSOC)) {
								$stockmini = $lignemoui['MIN(Stock)'];
							}
							echo "<select name=\"q_panier\" id=\"quantite_p\" />";
							if ($stockmini > 10) {
								echo "<option value=\"1\" selected>1</option> ";
								echo "<option value=\"2\">2</option> ";
								echo "<option value=\"3\">3</option> ";
								echo "<option value=\"4\">4</option> ";
								echo "<option value=\"5\">5</option> ";
								echo "<option value=\"6\">6</option> ";
								echo "<option value=\"7\">7</option> ";
								echo "<option value=\"8\">8</option> ";
								echo "<option value=\"9\">9</option> ";
								echo "<option value=\"10\">10</option> ";
							}
							else {
								for ($i=1; $i <= $stockmini ; $i++) { 
									if ($i == 1) {
										echo "<option value=\"1\" selected>1</option> ";
									}
									else {
										echo "<option value=\"".$i."\">".$i."</option> ";
									}
								}
							}
							echo "</select>";
							echo "<br/><br/><input style=\"float:right;\" type=\"submit\" name=\"ajouter\" value=\"Ajouter au panier\"/>";
							echo "</form></div>";
						}
						catch (PDOException $e) {
							echo "ERREUR :".$e->getMessage()."<br/>";
							die();
						}
					}
				}
				catch (PDOException $e) {
					echo "ERREUR :".$e->getMessage()."<br/>";
					die();
				}
				/*/////// FIN DU FORM ///////*/

				echo "</div>";
			}
			catch (PDOException $e) {
				echo "ERREUR :".$e->getMessage()."<br/>";
				die();
			}
		?>
		<div style="background-color: lightgrey;">
			<h2 style="text-align: center; padding-top: 5vw;">Détails du produit</h2>
			<?php
				include_once('connexions.php');
				$sql = "SELECT DISTINCT Description,Chaussures.id_chaussure,marque,modele,poids,type_course,type_foulee,sexe FROM Chaussures JOIN Stock ON Chaussures.id_Chaussure = Stock.id_chaussure WHERE Chaussures.id_chaussure = ".$id_chauss."";
				try {
					$res=$cx->query($sql);
					while ($tabl=$res->fetch(PDO::FETCH_ASSOC)) {
						$i=0;
	 					foreach ($tabl as $elt) {
	 						$elem[$i]=$elt;
				 			$i++;
						}
					}
					if ($elem[7] == 1) {
						$raclette = "Homme";
					}
					elseif ($elem[7] == 0) {
						$raclette = "Femme";
					}
					echo "<div style=\"padding-bottom: 2vw;\"><b>Marque</b> : ".$elem[2].". <b>Modèle</b> : ".$elem[3].". <b>Poids à l'unité</b> : ".$elem[4]."g. <b>Type de course</b> : ".$elem[5].". <b>Type de foulée</b> : ".$elem[6].". <b>Sexe</b> : ".$raclette.".</div>";
					echo "<div style=\"padding-bottom: 5vw;\">".$elem[0]."</div>";
				}
				catch (PDOException $e) {
					echo "ERREUR :".$e->getMessage()."<br/>";
					die();
				}
			?>
		</div>
	</body>
</html>