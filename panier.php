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
	unset($_SESSION['ajout_chaussure']); 
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
		<title>Prends ton pied - Panier</title>
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
			if (isset($message_stock)) { 
				echo "<div style=\"text-align: center; background-color: #FA5858; color: white; border: 1px black solid; padding:10px; margin-bottom: 5vw;\"><div>Commande annulée. Quantité demandée supérieure au stock pour les articles suivants :<br/>";
				$tabtab = $_SESSION['calimero'];
				$j = 0;
				foreach ($tabtab as $eltx) {
					for ($i=0; $i < count($eltx); $i++) { 
						${'eltx'.$j.$i} = $eltx[$i];
					}
					$j++;
				}	
				for ($i=0; $i < count($_SESSION['calimero']); $i++) { 
					include_once('connexions.php');
					$rathalos = ${'eltx'.$i.'0'};
					$sql9 = "SELECT marque, modele, id_chaussure FROM Chaussures WHERE id_chaussure = ".$rathalos."";
					try {
						$resx=$cx->query($sql9);
						while ($tabl=$resx->fetch(PDO::FETCH_ASSOC)) {
							echo "<div style=\"padding: 10px;\"><b>".$tabl['marque']." ".$tabl['modele']." (Pointure : ".${'eltx'.$i.'1'}.")</b></div>";
						}
					}
					catch (PDOException $e) {
						echo "ERREUR :".$e->getMessage()."<br/>";
						die();
					}
				}
				echo "<br/>Ces articles seront disponibles en stock d'ici 2 à 4 semaines.</div></div>";
				unset($_SESSION['calimero']);
			}
			if (isset($_SESSION['id_Client']) == FALSE) {
				$ichich = $id;
			}
			else {
				$ichich = $_SESSION['id_Client'];
			}
			$_SESSION['lourd'] = $ichich;
			include_once('connexions.php');
			$sql = "SELECT DISTINCT nb_articles, total, frais_de_port, tab, id_Client FROM Panier WHERE Panier.id_Client = ".$ichich."";
			try {
				$res2=$cx->query($sql);
				$result2 = $res2->fetchAll(PDO::FETCH_ASSOC);
				if ((sizeof($result2) != 0) || (sizeof($result2) != NULL)) {
					$sql2 = "SELECT DISTINCT nb_articles, total, frais_de_port, tab, id_Client FROM Panier WHERE Panier.id_Client = ".$_SESSION['lourd']."";
					try {
					$res=$cx->query($sql2);
					while ($tabl=$res->fetch(PDO::FETCH_ASSOC)) {
						$zbeubmoui = $tabl['total'];
						$mouizbeub = $tabl['frais_de_port'];
					if (($tabl['tab'] == "N;") || ($tabl['tab'] == NULL)) {
						echo "<div style=\"text-align: center;\"><div style=\"text-align: center; color: red; font-size: 22px;\"> VOTRE PANIER EST VIDE </div>";
						echo "<br/><input type=\"submit\" value=\"Aller sur la boutique\" onclick=\"window.location.href='index.php'\"  /></div>";
					}
					else {
						echo "<div style=\"float: left; margin-bottom: 5vw;\"><table style=\"text-align: center; margin-left: 10vw; margin-top: 5vw; cellpadding=\"0\" cellspacing=\"0\"\">";
						echo "<tr style=\"text-align: left;\"><td colspan=3 style=\"background-color: grey; color: white; padding: 10px;\"> VOTRE PANIER </td></tr>";
						$tab_des_articles = unserialize($tabl['tab']);
						$j=0;
						foreach ($tab_des_articles as $elt) {
							for ($i=0; $i < count($elt); $i++) { 
								${'elt'.$j.$i} = $elt[$i];
							}
							$j++;
						}
						
						for ($j=0; $j < count($tab_des_articles); $j++) { 
							echo "<tr style=\"border-bottom: 2px grey solid;\">";
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
									if ($elemmm[4] == 1) {
										$sexexe = "Homme";
									}
									else {
										$sexexe = "Femme";
									}
									$newpri = $elemmm[5] - ($elemmm[5]*$elemmm[7]/100);
									$newprix = sprintf("%01.2f", $newpri);
									echo "<td style=\"background-color: lightgrey;\"><img src = .".$elemmm[0]." style=\"width:16vw;height:16vw;\"></td>";
									echo "<td style=\"text-align: left; background-color: lightgrey; padding: 10px;\"> 
											<div style=\"font-size: 20px;\"><b>".$elemmm[1]." ".$elemmm[2]."</b></div><br/> 
											<div><b>Course</b> : ".$elemmm[3]."</div><br/>
											<div><b>Sexe</b> : ".$sexexe."</div><br/>
											<div><b>Pointure</b> : ".${'elt'.$j.'1'}."</div><br/>
											</td>";
									echo "<td style=\"padding: 10px; background-color: lightgrey;\"><form method=\"POST\" action=\"modifPanier.php\" name=\"testpp\"><input type=\"hidden\" name=\"id_chauss_modif\" value=\"".${'elt'.$j.'0'}."\" /><input type=\"hidden\" name=\"taille_chauss_modif\" value=\"".${'elt'.$j.'1'}."\" /><input type=\"submit\" name=\"modif_button\" value=\"Modifier\" />  <input type=\"submit\" name=\"suppr_button\" value=\"Supprimer\" /><br/>";
									include_once('connexions.php');
									$sqlmoui="SELECT MIN(Stock) FROM Stock JOIN Chaussures ON Stock.id_Chaussure = Chaussures.id_Chaussure WHERE Chaussures.id_chaussure = ".$elemmm[6]." && Stock.Stock != 0";
									try {
										$resmoui=$cx->query($sqlmoui);
										while ($lignemoui=$resmoui->fetch(PDO::FETCH_ASSOC)) {
											$stockmini = $lignemoui['MIN(Stock)'];
										}
										echo "<div style=\"display: inline-block; padding-top: 10px;\"><select style=\"float: left;\" name=\"q_panier\" id=\"quantite_p\" />";
										if ($stockmini > 10) {
											for ($i=1; $i <= 10 ; $i++) { 
												if ($i == ${'elt'.$j.'2'}) {
													echo "<option value=\"".$i."\" selected>".$i."</option> ";
												}
												else {
													echo "<option value=\"".$i."\">".$i."</option> ";
												}
											}
										}
										else {
											for ($i=1; $i <= $stockmini ; $i++) { 
												if ($i == ${'elt'.$j.'2'}) {
													echo "<option value=\"".$i."\" selected>".$i."</option> ";
												}
												else {
													echo "<option value=\"".$i."\">".$i."</option> ";
												}
											}
										}
										echo "</select></form>";
									}
									catch (PDOException $e) {
										echo "ERREUR :".$e->getMessage()."<br/>";
										die();
									}
									echo "<div style=\"float: left; opacity: 0;\">esp</div>";
									echo "<div style=\"font-size=18px; float: left; \"><b> ".sprintf("%01.2f",($newprix*${'elt'.$j.'2'}))."€</b></div></div></td>";
								}

							}
							catch (PDOException $e) {
								echo "ERREUR :".$e->getMessage()."<br/>";
								die();
							}
							echo "</tr>";
						}
						echo "</table></div>";		
										echo "<div style=\"float: left; margin-left: 5vw; margin-top: 5vw;\">";
				echo "<div style=\"background-color: lightgrey; text-align: center; padding: 15px;\">";
				echo "<div style=\"background-color: white; text-align: center; padding: 5px;\">";
				echo "<div style=\"font-size: 20px;\"><b>VOTRE COMMANDE :</b></div>";

				echo "<br/><div style=\"\"><div style=\"text-align: left;\"> SOUS-TOTAL </div>";
				echo "<div style=\"text-align: right;\">".$zbeubmoui." €</div></div>";

				echo "<div style=\"\"><div style=\"text-align: left;\"> LIVRAISON </div>";
				echo "<div style=\"text-align: right;\">".$mouizbeub." €</div></div>";

				echo "<div style=\"background-color: grey; color: white; padding: 5px; margin-top: 5px; text-align: center;\"><b><div style=\"float: left; text-align: left;\">TOTAL</div><div style=\" text-align: right;\">".sprintf("%01.2f",($zbeubmoui+$mouizbeub))." €</div></b></div>";

				echo "</div>";
				echo "<br/><input style=\"font-size: 18px; background-color: grey; color: white; padding: 5px;\" type=\"submit\" name=\"commande_button\" value=\"COMMANDER\" onclick=\"window.location.href='commande.php'\"  /><br/>";
				echo "<input style=\"margin-top: 10px; padding: 5px;\" type=\"submit\" name=\"promo_button\" value=\"Code promo ?\" />";
				echo "</div>";
				echo "</div>";			
					}

				}

			}
										
			catch (PDOException $e) {
				echo "ERREUR :".$e->getMessage()."<br/>";
				die();
			}

			}
				else {
					echo "<div style=\"text-align: center;\"><div style=\"text-align: center; color: red; font-size: 22px;\"> VOTRE PANIER EST VIDE </div>";
					echo "<br/><input type=\"submit\" value=\"Aller sur la boutique\" onclick=\"window.location.href='index.php'\"  /></div>";
				}
				
			}
			catch (PDOException $e) {
				echo "ERREUR :".$e->getMessage()."<br/>";
				die();
			}
		?>
	</body>
</html>