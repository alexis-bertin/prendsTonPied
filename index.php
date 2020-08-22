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
		<title>Prends ton pied</title>
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
		<form method="POST" action="index.php" name="test1" >
			<table style="background-color: grey; width: 100%; margin-bottom: 5vw;">
			<tr style="margin-top: 5px;">
				<td style="padding: 10px; background-color: lightgrey; margin-bottom: 10px; ">
					<h2 style="margin-bottom: 5px;">FILTRÉ PAR</h2>
				    <INPUT id="crit1" onClick="checkedd()" TYPE="checkbox" name="zbeub" VALUE="promos" <?php $check="checked=\"checked\""; if ( $_POST['zbeub'] == "promos") echo $check; ?> readonly > Promotions
				    <br/><INPUT id="crit2" onClick="checkedd2()" TYPE="checkbox" name="zbeub" VALUE="nouveau" <?php $check="checked=\"checked\""; if ( $_POST['zbeub'] == "nouveau") echo $check; ?> readonly > Nouveautés
				    <br/><INPUT id="crit3" onClick="checkedd3()" TYPE="checkbox" name="zbeub" VALUE="popu" <?php $check="checked=\"checked\""; if ( $_POST['zbeub']== "popu") echo $check; ?> readonly > Popularité
				</td>
				<?php
					//Appel de la BDD
					include_once('connexions.php');
					//Requête sql
					$sql="SELECT DISTINCT marque FROM Chaussures";
					$sql2="SELECT DISTINCT type_course FROM Chaussures";
					$sql3="SELECT DISTINCT pointure FROM Stock JOIN Chaussures ON Stock.id_Chaussure = Chaussures.id_Chaussure";
					$sql4="SELECT DISTINCT MAX(prix) FROM Chaussures";
					$res4=$cx->query($sql4);
					while ($ligne=$res4->fetch(PDO::FETCH_ASSOC)) {
						$prixmax=$ligne['MAX(prix)'];
					}
					try {
						$res=$cx->query($sql);
						//Mise en place des lignes comprenant les données de la BDD
						echo "<td style=\"background-color: grey; padding: 10px;\"><table><tr><td><h3 style=\"margin-bottom: 4px; \">Marque</h3>";
						while ($ligne=$res->fetch(PDO::FETCH_ASSOC)) {
							echo "<input type=\"checkbox\" name=options[] value=".$ligne['marque'].">".$ligne['marque'];
						}
						$res2=$cx->query($sql2);
						echo "</td><td style=\"padding-left: 30px; \">";
						echo "<h3 style=\"margin-bottom: 4px; \">Type de course</h3>";
						echo "<select name=\"t_course\" id=\"course\" />";
						echo "<option value=\"\"></option>";
							while ($ligne=$res2->fetch(PDO::FETCH_ASSOC)) {
		                        echo "<option value=".$ligne['type_course'].">".$ligne['type_course']."</option>";
							}
						echo "</select></td></tr><tr><td style=\"padding-top: 10px; \">";
						$res3=$cx->query($sql3);
						echo "<h3 style=\"margin-bottom: 4px; \">Pointure</h3>";
						//Mise en place des lignes comprenant les données de la BDD
						while ($ligne=$res3->fetch(PDO::FETCH_ASSOC)) {
							echo "<input type=\"checkbox\" name=options2[] value=".$ligne['pointure'].">".$ligne['pointure'];
						}
						echo "</td><td style=\"padding-left: 30px; \">";
						echo "<h3 style=\"margin-bottom: 4px; \">Prix</h3>";
						echo "<div id=\"slider\" style=\"margin-bottom:5px;\"></div>";
						echo "<input type=\"text\" id=\"slider-snap-value-lower\"  name=\"prixmini\" style=\"float: left; width: 60px; background: none; border: none;\"></input> <input type=\"text\" id=\"slider-snap-value-upper\"  name=\"prixmaxi\" style=\"float: right; width: 60px; background: none; border: none; margin-left: 2vw;\"></input>";
						echo "</td></tr></table></td>";
					}
					catch (PDOException $e) {
						echo "ERREUR :".$e->getMessage()."<br/>";
						die();
					}
				?>
			</tr>
			<tr style="background-color: grey; padding:0; height: 0; overflow: hidden;">
				<td style="background-color: grey;  padding:0; height: 0; overflow: hidden;"></td><td style="float: right; background-color: grey; padding: 0; margin-top: -3vw; margin-right: 1vw;"><input type="submit" name="valider" value="Valider" style="font-size: 2vw; background:#424242; color:white; cursor:hand; border:solid 1px black;" /></td>
			</tr>
			</table>
		</form>
		<?php
		//Appel de la BDD
			include_once('connexions.php');
			if ($_POST['zbeub'] == "promos") {
				$sql = "SELECT DISTINCT img_chaussure,marque,modele,prix,promotion,Chaussures.id_chaussure FROM Chaussures JOIN Stock ON Chaussures.id_Chaussure = Stock.id_chaussure WHERE (type_course LIKE '%".$_POST['t_course']."%') AND (marque LIKE '".implode("%' OR marque  LIKE '", $_POST["options"])."%') AND (pointure LIKE '".implode("%' OR pointure  LIKE '", $_POST["options2"])."%') AND (prix BETWEEN '".$_POST["prixmini"]."' AND '". $_POST["prixmaxi"]."') AND (promotion != 0) ORDER BY promotion DESC" ;
			}
			elseif ($_POST['zbeub'] == "nouveau") {
				$sql = "SELECT DISTINCT img_chaussure,marque,modele,prix,promotion,Chaussures.id_chaussure FROM Chaussures JOIN Stock ON Chaussures.id_Chaussure = Stock.id_chaussure WHERE (type_course LIKE '%".$_POST['t_course']."%') AND (marque LIKE '".implode("%' OR marque  LIKE '", $_POST["options"])."%') AND (pointure LIKE '".implode("%' OR pointure  LIKE '", $_POST["options2"])."%') AND (prix BETWEEN '".$_POST["prixmini"]."' AND '". $_POST["prixmaxi"]."') ORDER BY date_depot DESC";
			}
			elseif ($_POST['zbeub'] == "popu") {
				$sql = "SELECT DISTINCT img_chaussure,marque,modele,prix,promotion,Chaussures.id_chaussure FROM Chaussures JOIN Stock ON Chaussures.id_Chaussure = Stock.id_chaussure WHERE (type_course LIKE '%".$_POST['t_course']."%') AND (marque LIKE '".implode("%' OR marque  LIKE '", $_POST["options"])."%') AND (pointure LIKE '".implode("%' OR pointure  LIKE '", $_POST["options2"])."%') AND (prix BETWEEN '".$_POST["prixmini"]."' AND '". $_POST["prixmaxi"]."') ORDER BY nb_achat_C DESC" ;
			}
			elseif (($_POST['prixmini'] != NULL) || ($_POST['prixmaxi'] != NULL)) {
				$sql = "SELECT DISTINCT img_chaussure,marque,modele,prix,promotion,Chaussures.id_chaussure FROM Chaussures JOIN Stock ON Chaussures.id_Chaussure = Stock.id_chaussure WHERE (type_course LIKE '%".$_POST['t_course']."%') AND (marque LIKE '".implode("%' OR marque  LIKE '", $_POST["options"])."%') AND (pointure LIKE '".implode("%' OR pointure  LIKE '", $_POST["options2"])."%') AND (prix BETWEEN '".$_POST["prixmini"]."' AND '". $_POST["prixmaxi"]."')";
			}
			else {
				$sql = "SELECT DISTINCT img_chaussure,marque,modele,prix,promotion,Chaussures.id_chaussure FROM Chaussures JOIN Stock ON Chaussures.id_Chaussure = Stock.id_chaussure WHERE (type_course LIKE '%".$_POST['t_course']."%') AND (marque LIKE '".implode("%' OR marque  LIKE '", $_POST["options"])."%') AND (pointure LIKE '".implode("%' OR pointure  LIKE '", $_POST["options2"])."%')";
			}
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
					echo "<div style=\"float: left; background-color: lightgrey; margin: 15px; padding: 10px; vertical-align:middle;\">";
					if ($elem[4] != 0) {
						echo "<div style=\"position: absolute; padding: 5px; color: white; background-color: red; \">".$elem[4]."%</div>";
						$newpri = $elem[3] - ($elem[3]*$elem[4]/100);
						$newprix = sprintf("%01.2f", $newpri);
					}
					echo "<a href=\"page_produit.php?iddd=".$elem[5]."\" style=\"text-decoration: none; color: black;\"><img src = .".$elem[0]." style=\"width:15vw;height:15vw;\">";
					echo "<b><div style=\"margin-top:10px;\">".$elem[1]." ".$elem[2]."</div></b>";
					if ($elem[4] != 0) {
						echo "<div style=\"margin-top:10px;\">".$newprix."€ <strike>".$elem[3]."€</strike></div></a></div>";
					}
					else {
						echo "<div style=\"margin-top:10px;\">".$elem[3]."€</div></a></div>";
					}
				} 
				echo "</div>";
			}
			catch (PDOException $e) {
				echo "ERREUR :".$e->getMessage()."<br/>";
				die();
			}
		?>
		<script src="slide/nouislider.min.js"></script>
		<script type="text/javascript">
			var prixMaximum = <?php echo json_encode($prixmax); ?>;
			var slider = document.getElementById('slider');
			noUiSlider.create(slider, {
				start: [0, prixMaximum],
				connect: true,
				step: 1,
				range: {
					'min': 0,
					'max': parseInt(prixMaximum)
				}

			});
			var snapValues = [
			document.getElementById('slider-snap-value-lower'),
			document.getElementById('slider-snap-value-upper')
			];

			slider.noUiSlider.on('update', function( values, handle ) {
				snapValues[handle].value = values[handle]+" €";
			});
		</script>
	</body>
</html>