<?php 
	session_start(); 
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
<?php
			$nom=$_POST['nom']; 
			$prenom=$_POST['prenom'];
			$tel=$_POST['tel'];
			$cp=$_POST['cp']; 
			$ville=$_POST['ville']; 
			$norue=$_POST['norue']; 
			$nurue=$_POST['nurue']; 
			$appart=$_POST['appart'];  
			$email=$_POST['email']; 
			$id=$_SESSION['id_Client'];

			$_SESSION['cp_haha']=$cp;
			$_SESSION['ville_haha']=$ville;
			$_SESSION['norue_haha']=$norue;
			$_SESSION['nurue_haha']=$nurue;
			$_SESSION['appart_haha']=$appart;

			// VERIFICATION VALIDITE COORDONNEES
			if ((preg_match("/^\pL+(?>[- ']\pL+)*$/u", $nom)) && (preg_match("/^\pL+(?>[- ']\pL+)*$/u", $prenom)) && (filter_var($email, FILTER_VALIDATE_EMAIL)) && (((strlen($tel)==10) && (ctype_digit($tel)))) && (((strlen($cp)==5) && (ctype_digit($cp)))) && ((preg_match("/^\pL+(?>[- ']\pL+)*$/u", $ville))) && ((preg_match("/^\pL+(?>[- ']\pL+)*$/u", $norue))) && ((ctype_digit($nurue)) || empty($nurue)) && ((ctype_digit($appart)) || empty($appart))) {
				$id_Client_com = $_SESSION['yeahyeah'];
				$_SESSION['com_fin'] = $id_Client_com;
				include_once('connexions.php');
				$sql2 = "SELECT nb_articles, total, frais_de_port, Panier.id_Client, tab FROM Panier JOIN Client ON Panier.id_Client = Client.id_Client WHERE Panier.id_Client = ".$id_Client_com."";
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
						for ($i=0; $i < count($tab_des_articles); $i++) { 
							include_once('connexions.php');
							$sqlz="SELECT DISTINCT Stock FROM Stock JOIN Chaussures ON Stock.id_Chaussure = Chaussures.id_Chaussure WHERE Stock.pointure = ".${'elt'.$i.'1'}." && Chaussures.id_chaussure = ".${'elt'.$i.'0'}."";
							try {
								$resz=$cx->query($sqlz);
								while ($lignez=$resz->fetch(PDO::FETCH_ASSOC)) {
									if ($lignez['Stock'] < ${'elt'.$i.'2'}) {

										// TABLEAU DES CHAUSSURES A ENLEVER DU PANIER
										$chauss_a_supprimer[] = array((${'elt'.$i.'0'}),(${'elt'.$i.'1'}),(${'elt'.$i.'2'}));
									}
								}
							}
							catch (PDOException $e) {
								echo "ERREUR :".$e->getMessage()."<br/>";
								die();
							}
						}

						// VERIFICATION STOCK
						if (empty($chauss_a_supprimer)) {

							// ENVOI DE LA COMMANDE				
							include_once("commande_effectue.php");
							header("location: commande_effectue.php");
							exit(); 
						}

						// /!\ PROBLEME STOCK 
						else {
							include_once('connexions.php');
							$sqlZE = "SELECT DISTINCT nb_articles, total, frais_de_port, tab, id_Client FROM Panier WHERE Panier.id_Client = ".$id_Client_com."";
							try {
								$res2=$cx->query($sqlZE);
								while ($tabl=$res2->fetch(PDO::FETCH_ASSOC)) {
									$ancien_nbart = $tabl['nb_articles'];
									$ancien_total = $tabl['total'];
									$tab_des_articles = unserialize($tabl['tab']);
									$j=0;
									foreach ($tab_des_articles as $elt) {
										for ($i=0; $i < count($chauss_a_supprimer); $i++) { 
											if ($elt == $chauss_a_supprimer[$i]) {
												$art_suppr[] = $elt;
												$jailadalle += $chauss_a_supprimer[$i][2];
												$vardelamortquitue += 1;
											}
											else {
												$vardelamortquitue += 0;
											}	
										}
										if ($vardelamortquitue == 0) {
											$newnewnew[] = $elt;
										}
										$vardelamortquitue = 0;
										$j++;
									}
									$_SESSION['calimero'] = $art_suppr;
									$nbart = $ancien_nbart - $jailadalle;
									//Recherche prix de l'article supprimé
									try {
										foreach ($art_suppr as $unangedansleciel) {
											$sql="SELECT Prix, promotion FROM Chaussures WHERE id_chaussure = ".$unangedansleciel[0]."";
											$res=$cx->query($sql);
											while ($tabl=$res->fetch(PDO::FETCH_ASSOC)) {
												if ($tabl['promotion'] != 0) {
													$newpri = $tabl['Prix'] - ($tabl['Prix']*$tabl['promotion']/100);
													$ancien_prix += sprintf("%01.2f", (($newpri)*$unangedansleciel[2]));
												}
												else {
													$ancien_prix += sprintf("%01.2f", (($tabl['Prix'])*$unangedansleciel[2]));
												}
											}
										}
									}
									catch (PDOException $e) {
										echo "Erreur :".$e->getMessage()."<br/>";
										die();
									}
									$total = $ancien_total - $ancien_prix;
									if ($total >= 100) {
										$frais_de_port = 0;
									}
									else {
										$frais_de_port = 20;
									}
									$id_Client_panier = $_SESSION['id_Client'];
									$ancien_tab = $newnewnew;
									$real_tab = serialize($ancien_tab);
									try {
										$sql="UPDATE Panier SET nb_articles = :nbart, total = :total, frais_de_port = :fdp, id_Client = :idc, tab = :tab WHERE id_Client = :idc";
										$prep=$cx->prepare($sql);
										$tabVal=array(':nbart'=>$nbart, ':total'=>$total, ':fdp'=>$frais_de_port, ':idc'=>$id_Client_panier, ':tab'=> $real_tab);
										$res=$prep->execute($tabVal);
									}
									catch (PDOException $e) {
										echo "Erreur :".$e->getMessage()."<br/>";
										die();
									}
									if ($nbart == 0) {
										try {
											$sql="UPDATE Panier SET total = :total";
											$prep=$cx->prepare($sql);
											$tabVal=array(':total' => 0);
											$res=$prep->execute($tabVal);
										}
										catch (PDOException $e) {
											echo "Erreur :".$e->getMessage()."<br/>";
											die();
										}
									}
								}
							}
							catch (PDOException $e) {
								echo "ERREUR :".$e->getMessage()."<br/>";
								die();
							}
							$message_stock=true;
							include_once("panier.php");
						}
					}
				}
				catch (PDOException $e) {
					echo "ERREUR :".$e->getMessage()."<br/>";
					die();
				}




//////////////////////////////////////////////////////////////////////////////////////////////////
/*

*/
			}
			// /!\ COORDONNES NON VALIDES
			else {
				$message_coord=true;
				include_once("commande.php");
			}
?>