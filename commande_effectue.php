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
		<title>Prends ton pied - Commande effectuée</title>
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
			$id_ClientCom = $_SESSION['com_fin'];
			include_once('connexions.php');
			$sql2 = "SELECT total, frais_de_port, Panier.id_Client, tab, id_Panier FROM Panier JOIN Client ON Panier.id_Client = Client.id_Client WHERE Panier.id_Client = ".$id_ClientCom."";
			try {
				$ress=$cx->query($sql2);
				while ($tabl=$ress->fetch(PDO::FETCH_ASSOC)) {
					$total = $tabl['total']+$tabl['frais_de_port'];
					$tab = $tabl['tab'];
					$id_Client = $tabl['id_Client'];
					$id_Panier = $tabl['id_Panier'];

					// AJOUT COMMANDE
					try {
						include_once('connexions.php');
						$sql="INSERT INTO  Commande VALUES (:idpapa, :total, :tab, :idclient, DATE(NOW()))";
						$prep=$cx->prepare($sql);
						$tabVal=array(':idpapa'=>$id_Panier, ':total'=>$total, ':tab'=>$tab, ':idclient'=>$id_Client);
						$res=$prep->execute($tabVal);
					}
					catch (PDOException $e) {
						echo "Erreur :".$e->getMessage()."<br/>";
						die();
					}

					// AJOUT HISTORIQUE
					try {
						include_once('connexions.php');
						$sql22="INSERT INTO Historique VALUES (NULL, :idpapapa, :zero)";
						$prep2=$cx->prepare($sql22);
						$tabVal2=array(':idpapapa'=>$id_Panier, ':zero'=>0);
						$res2=$prep2->execute($tabVal2);
					}
					catch (PDOException $e) {
						echo "Erreur :".$e->getMessage()."<br/>";
						die();
					}




					// ENVOI DU MAIL 
					$EmailTo = $_SESSION['email'];
					$Subject = 'Récapitulatif de votre commande';
							 
					//Prépare le texte du mail
					$Body .= "Bonjour,<br/> ";
					$Body .= "Vous venez de commander sur prendstonpied.fr et nous vous remercions pour la confiance que vous nous accordez.<br/><br/>";
					$Body .= "Voici un récapitulatif de votre commande :<br/>";

					///////////////////////////////////////////////////////////////////////////////////


					include_once('connexions.php');
					$sql2121 = "SELECT nb_articles, total, frais_de_port, Panier.id_Client, tab FROM Panier JOIN Client ON Panier.id_Client = Client.id_Client WHERE Panier.id_Client = ".$id_ClientCom."";
					try {
						$res2121=$cx->query($sql2121);
						while ($tabl=$res2121->fetch(PDO::FETCH_ASSOC)) {
							$tab_des_articles = unserialize($tabl['tab']);
							$_SESSION['yeahyeah'] = $tabl['id_Client'];
							$j=0;
							foreach ($tab_des_articles as $elt) {
								for ($i=0; $i < count($elt); $i++) { 
									${'elt'.$j.$i} = $elt[$i];
								}
								$j++;
							}
							$Body .= "<div>";
							for ($j=0; $j < count($tab_des_articles); $j++) {
								$mouimoui = ${'elt'.$j.'0'};
								include_once('connexions.php');
								$sqlsql = "SELECT DISTINCT img_chaussure, marque, modele, type_course, sexe, prix, id_chaussure, promotion, nb_achat_C FROM Chaussures WHERE id_chaussure = ".$mouimoui."";
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
										$Body .= "<br/><div>";
										//Ligne 1 (quantite+marque+modele)
										$Body .= "<div>".${'elt'.$j.'2'}." x ".$elemmm[1]." ".$elemmm[2]."</div>";
										//Ligne 2 (pointure)
										$Body .= "<div>(Pointure : ".${'elt'.$j.'1'}.")</div>";
										//Ligne 3 (prix)
										$Body .= "<div>".sprintf("%01.2f",($newprix*${'elt'.$j.'2'}))."&euro;</div>";
										$Body .= "</div>";

										// CHANGEMENT NB ACHAT CHAUSSURE
										try {
											include_once("connexions.php");
											$nouvnouv = $elemmm[8] + ${'elt'.$j.'2'};
											$sql="UPDATE Chaussures SET nb_achat_C = :qqq WHERE id_chaussure = :idd";
											$prep=$cx->prepare($sql);
											$tabVal=array(':qqq'=>$nouvnouv, ':idd'=>$elemmm[6]);
											$res=$prep->execute($tabVal);
										}
										catch (PDOException $e) {
											echo "Erreur :".$e->getMessage()."<br/>";
											die();
										}

										// CHANGEMENT DU STOCK 
										include_once('connexions.php');
										$sqlZE = "SELECT DISTINCT id_stock, Stock, id_chaussure, Pointure FROM Stock WHERE Stock.id_chaussure = ".$elemmm[6]." && Stock.Pointure = ".${'elt'.$j.'1'}."";
										try {
											$res2=$cx->query($sqlZE);
											while ($tablbn=$res2->fetch(PDO::FETCH_ASSOC)) {
												$ancien_stock = $tablbn['Stock'];
												$nouveau_stock = $ancien_stock - ${'elt'.$j.'2'};
												try {
													include_once("connexions.php");
													$sql="UPDATE Stock SET Stock.Stock = :stosto WHERE Stock.id_chaussure = ".$elemmm[6]." && Stock.Pointure = ".${'elt'.$j.'1'}."";
													$prep=$cx->prepare($sql);
													$tabVal=array(':stosto'=>$nouveau_stock);
													$res=$prep->execute($tabVal);
												}
												catch (PDOException $e) {
													echo "Erreur :".$e->getMessage()."<br/>";
													die();
												}
											}
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
							}
							$Body .= "<br/><div> <div>Frais de livraison </div> <div>".sprintf("%01.2f",$tabl['frais_de_port'])."&euro;</div> </div>";
							$Body .= "</div>";
							$Body .= "<div>";
							$Body .= "<br/><div>TOTAL </div>";
							$Body .= "<div>".sprintf("%01.2f",(($tabl['total'])+sprintf("%01.2f",$tabl['frais_de_port'])))."&euro;</div>";
							$Body .= "</div>";
						}
					}
					catch (PDOException $e) {
						echo "ERREUR :".$e->getMessage()."<br/>";
						die();
					}

					///////////////////////////////////////////////////////////////////////

					$Body .= "<br/>ADRESSE DE LIVRAISON : <br/>";
					$Body .= "<div>".$_SESSION['cp_haha']." ".$_SESSION['ville_haha']." ";
					if ((($_SESSION['nurue_haha']) != 0) && (($_SESSION['nurue_haha']) != NULL)) {
						$Body .= $_SESSION['nurue_haha']." ";
					}
					$Body .= $_SESSION['norue_haha']." ";
					if ((($_SESSION['appart_haha']) != 0) && (($_SESSION['appart_haha']) != NULL)) {
						$Body .= "appart n°".$_SESSION['appart_haha']."</div>";
					}
					else {
						$Body .= "</div>";
					}
					$Body .= "<br/>AU NOM DE : <br/>";
					$Body .= $_SESSION['nom_haha']." ".$_SESSION['prenom_haha'];

					$Body .= "<br/><br/>Vous serez livré dans les plus brefs délais par le transporteur Chronopost. Un suivi vous sera fourni par leur groupe.";
					$Body .= "<br/><br/>Toute l'équipe vous remercie,<br/>";
					$Body .= "<div style=\"margin-bottom: 20px;\">PRENDS TON PIED</div><br/>";
					$Body .= "\n";

					$headers ='From: "Prends ton pied"<prendstonpied@gmail.com>'."\n"; 
					$headers .='Reply-To: prendstonpied@gmail.com'."\n"; 
					$headers .='Content-Type: text/html; charset=iso-8859-1' ."\r\n";
					$headers .='Content-Transfer-Encoding: 8bit'; 

					$success = "";
							 
					//Envoie le mail
					$success = mail($EmailTo, utf8_decode($Subject), utf8_decode($Body), $headers);

					echo "<div style=\"font-size: 30px; text-align: center; margin-top: 10vw; padding: 10px;\"> VOTRE COMMANDE A ÉTÉ EXPÉDIÉE </div>";

					echo "<div style=\"font-size: 18px; text-align: center; margin-top: 4vw; padding: 10px;\"> Un courriel comportant un récapitulatif vous a été envoyé à votre adresse mail. </div>";

					echo "<div style=\"text-align: center; margin-top: 2vw; \"><input style=\"\" type=\"submit\" value=\"Retourner sur la boutique\" onclick=\"window.location.href='index.php'\" /></div>";

					// SUPPRESSION DU PANIER 
					try {
						include_once("connexions.php");
						$sqlq="DELETE FROM Panier WHERE Panier.id_Client = ".$id_ClientCom."";
						$prep3=$cx->prepare($sqlq);
						$res=$prep3->execute();
					}
					catch (PDOException $e) {
						echo "Erreur :".$e->getMessage()."<br/>";
						die();
					}	

				}
			}
			catch (PDOException $e) {
				echo "ERREUR :".$e->getMessage()."<br/>";
				die();
			}
			unset($_SESSION['com_fin']); 
		?>
	</body>
</html>