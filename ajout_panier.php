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
	$pointureC = $_POST['pointure_p'];
	$quantiteC = $_POST['q_panier'];
	$id_chaussure_ajoute = $_SESSION['ajout_chaussure'];
	if (isset($_SESSION['id_Client']) == FALSE) {
		$prob_co=true;
		include_once("page_produit.php");
		header("location: page_produit.php");
		exit();
	}
	elseif (isset($pointureC) == FALSE) {
		$prob_point=true;
		include_once("page_produit.php");
		header("location: page_produit.php");
		exit();
	}
	else {
	include_once('connexions.php');
	$sql1234 = "SELECT DISTINCT prix, promotion FROM Chaussures WHERE Chaussures.id_chaussure = ".$id_chaussure_ajoute."";
	try {
		$res2121=$cx->query($sql1234);
		while ($tabl=$res2121->fetch(PDO::FETCH_ASSOC)) {
			if ($tabl['promotion'] != 0) {
				$newpri = $tabl['prix'] - ($tabl['prix']*$tabl['promotion']/100);
				$prix_chaussure_ajoute = sprintf("%01.2f", $newpri);
			}
			else {
				$prix_chaussure_ajoute = sprintf("%01.2f", $tabl['prix']);
			}
		}
	}
	catch (PDOException $e) {
		echo "ERREUR :".$e->getMessage()."<br/>";
		die();
	}

		$sql = "SELECT DISTINCT id_Client FROM Panier WHERE Panier.id_Client = ".$_SESSION['id_Client']."";
		try {
			$res=$cx->query($sql);
			while ($tabl=$res->fetch(PDO::FETCH_ASSOC)) {
				$iddupanier = $tabl['id_Client'];
			}

			/*////// DANS LE CAS OU LE PANIER ETAIT VIDE ///////*/
			if (isset($iddupanier) == FALSE) {
				$nbart = $quantiteC;
				$total = $prix_chaussure_ajoute*$quantiteC;
				if ($total >= 100) {
					$frais_de_port = 0;
				}
				else {
					$frais_de_port = 20;
				}
				$id_Client_panier = $_SESSION['id_Client'];
				$tab[] = array($id_chaussure_ajoute, $pointureC, $quantiteC);
				$real_tab = serialize($tab);
				try {
					$sql="INSERT INTO Panier VALUES (NULL, :nbart, :total, :fdp, :idc, :tab)";
					$prep=$cx->prepare($sql);
					$tabVal=array(':nbart'=>$nbart, ':total'=>$total, ':fdp'=>$frais_de_port, ':idc'=>$id_Client_panier, ':tab'=> $real_tab);
					$res=$prep->execute($tabVal);
				}
				catch (PDOException $e) {
					echo "Erreur :".$e->getMessage()."<br/>";
					die();
				}
			}

			/*////// DANS LE CAS OU LE PANIER N'ETAIT PAS VIDE ///////*/
			else {
				$sql = "SELECT DISTINCT nb_articles, total, tab FROM Panier WHERE Panier.id_Client = ".$iddupanier."";
				try {
					$res=$cx->query($sql);
					while ($tabl=$res->fetch(PDO::FETCH_ASSOC)) {
						$ancien_nbart = $tabl['nb_articles'];
						$ancien_total = $tabl['total'];
						$ancien_tab = unserialize($tabl['tab']);
					}
					$nbart = $ancien_nbart + $quantiteC;
					$total = $ancien_total + ($prix_chaussure_ajoute*$quantiteC);
					if ($total >= 100) {
						$frais_de_port = 0;
					}
					else {
						$frais_de_port = 20;
					}
					$id_Client_panier = $iddupanier;
					$ancien_tab[] = array($id_chaussure_ajoute, $pointureC, $quantiteC);
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
		$ajout_effectue=true;
		$nb_effectue=$quantiteC;
		include_once("page_produit.php");
		header("location: page_produit.php");
		exit();
	}
?>