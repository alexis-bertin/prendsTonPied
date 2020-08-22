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
		if (isset($_SESSION['id']) == FALSE) {
			$_SESSION['id_Client']=$_COOKIE['id_prendstonpied'];
		}
		$_SESSION['mdp']=$_COOKIE['mdp_prendstonpied'];
    	$_SESSION['nom']=$_COOKIE['nom_prendstonpied'];
		$_SESSION['prenom']=$_COOKIE['prenom_prendstonpied'];
		$_SESSION['ville']=$_COOKIE['ville_prendstonpied'];
		$_SESSION['tel']=$_COOKIE['tel_prendstonpied'];
		$_SESSION['cp']=$_COOKIE['cp_prendstonpied'];
		$_SESSION['norue']=$_COOKIE['norue_prendstonpied'];
		$_SESSION['nurue']=$_COOKIE['nurue_prendstonpied'];
		$_SESSION['appart']=$_COOKIE['appart_prendstonpied'];
		$_SESSION['id_Client']=$_COOKIE['id_prendstonpied'];
    } 
?>

<?php
	///////////////// MODIFIER PANIER /////////////////////
	if (isset($_POST['modif_button'])) {
		$idchausschauss = $_POST['id_chauss_modif'];
		$taillechausschauss = $_POST['taille_chauss_modif'];
		$nouvelle_q = $_POST['q_panier'];
		$cchiant = $_SESSION['id_Client'];
		include_once('connexions.php');
			$sqlZE = "SELECT DISTINCT nb_articles, total, frais_de_port, tab, id_Client FROM Panier WHERE Panier.id_Client = ".$cchiant."";
			try {
				$res2=$cx->query($sqlZE);
				while ($tabl=$res2->fetch(PDO::FETCH_ASSOC)) {
					$ancien_nbart = $tabl['nb_articles'];
					$ancien_total = $tabl['total'];
					$tab_des_articles = unserialize($tabl['tab']);
					$j=0;
					foreach ($tab_des_articles as $key => $elt) {
						if ((in_array($idchausschauss, $elt) == TRUE) && (in_array($taillechausschauss, $elt) == TRUE)) {
							$newnewnew[$key] = $elt;
							$ancienne_quantite = $newnewnew[$key][2];
							$newnewnew[$key][2] = $nouvelle_q;
						}
						else {
							$newnewnew[$key] = $elt;
						}
					}
					$nbart = $ancien_nbart + ($nouvelle_q - $ancienne_quantite);
					//Recherche prix de l'article supprimé
					try {
						include_once('connexions.php');
						$sqlAZ="SELECT Prix, promotion FROM Chaussures WHERE id_chaussure = ".$idchausschauss."";
						$resAZ=$cx->query($sqlAZ);
						while ($tabl=$resAZ->fetch(PDO::FETCH_ASSOC)) {
							if ($tabl['promotion'] != 0) {
								$newpri = $tabl['Prix'] - ($tabl['Prix']*$tabl['promotion']/100);
								$ancien_prix = sprintf("%01.2f", $newpri);
							}
							else {
								$ancien_prix = sprintf("%01.2f", $tabl['Prix']);
							}
						}
						$total = $ancien_total + (($ancien_prix*$nouvelle_q)-($ancien_prix*$ancienne_quantite));
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
							include_once('connexions.php');
							$sql34="UPDATE Panier SET nb_articles = :nbart, total = :total, frais_de_port = :fdp, id_Client = :idc, tab = :tab WHERE id_Client = :idc";
							$prep2=$cx->prepare($sql34);
							$tabVal=array(':nbart'=>$nbart, ':total'=>$total, ':fdp'=>$frais_de_port, ':idc'=>$id_Client_panier, ':tab'=> $real_tab);
							$res32=$prep2->execute($tabVal);
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
		include_once("panier.php");
		header("location: panier.php");
		exit(); 
	}






	///////////// SUPPRIMER ARTICLE PANIER ///////////////
	elseif (isset($_POST['suppr_button'])) {
		$idchausschauss = $_POST['id_chauss_modif'];
		$taillechausschauss = $_POST['taille_chauss_modif'];
		$cchiant = $_SESSION['id_Client'];
		$nouvelle_q = $_POST['q_panier'];
		include_once('connexions.php');
			$sqlZE = "SELECT DISTINCT nb_articles, total, frais_de_port, tab, id_Client FROM Panier WHERE Panier.id_Client = ".$cchiant."";
			try {
				$res2=$cx->query($sqlZE);
				while ($tabl=$res2->fetch(PDO::FETCH_ASSOC)) {
					$ancien_nbart = $tabl['nb_articles'];
					$ancien_total = $tabl['total'];
					$tab_des_articles = unserialize($tabl['tab']);
					$j=0;
					foreach ($tab_des_articles as $elt) {
						if ((in_array($idchausschauss, $elt) == TRUE) && (in_array($taillechausschauss, $elt) == TRUE)) {
							$art_suppr = $elt;
						}
						else {
							$newnewnew[] = $elt;
						}
					}
					$nbart = $ancien_nbart - $art_suppr[2];
					//Recherche prix de l'article supprimé
					try {
						$sql="SELECT Prix, promotion FROM Chaussures WHERE id_chaussure = ".$art_suppr[0]."";
						$res=$cx->query($sql);
						while ($tabl=$res->fetch(PDO::FETCH_ASSOC)) {
							if ($tabl['promotion'] != 0) {
								$newpri = $tabl['Prix'] - ($tabl['Prix']*$tabl['promotion']/100);
								$ancien_prix2 = sprintf("%01.2f", $newpri);
							}
							else {
								$ancien_prix2 = sprintf("%01.2f", $tabl['Prix']);
							}
							$ancien_prix = $ancien_prix2*$nouvelle_q;
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
		include_once("panier.php");
		header("location: panier.php");
		exit();
	}
?>