<?php 
	session_start(); 
    //DEFINITION SESSION ID APRES INSCRIPTION
        setcookie('auto_prendstonpied','',time(), '/');
        setcookie('id_prendstonpied','',time(), '/');
        setcookie('mdp_prendstonpied','',time(), '/');
        setcookie('nom_prendstonpied','',time(), '/');
        setcookie('prenom_prendstonpied','',time(), '/');
        setcookie('cp_prendstonpied','',time(), '/');
        setcookie('ville_prendstonpied','',time(), '/');
        setcookie('norue_prendstonpied','',time(), '/');
        setcookie('nurue_prendstonpied','',time(), '/');
        setcookie('appart_prendstonpied','',time(), '/');
        setcookie('tel_prendstonpied','',time(), '/');
        setcookie('mail_prendstonpied','',time(), '/');
?>
<?php
	include_once("connexions.php");
	try {
		$x=$_SESSION['nomzbeub'];
        $y=$_SESSION['id_Clientzbeub'];
	    $sql="DELETE FROM Client WHERE nom= :x";
	    $prep=$cx->prepare($sql);
		$tabVal=array(':x'=>$x);
		$res=$prep->execute($tabVal);
        include_once("connexions.php");
        try {
            $sql2="DELETE FROM Panier WHERE id_Client = :y";
            $prep2=$cx->prepare($sql2);
            $tabVal2=array(':y'=>$y);
            $res2=$prep2->execute($tabVal2);
        }
        catch (PDOException $e) {
          echo "Erreur :".$e->getMessage()."<br/>";
          die();
        }

        echo "<div style=\"height: 5vw; background-color: lightgrey; margin-bottom: 2vw;\">";
        echo "<input style=\"top: 2vw; left: 2vw; position: absolute;\" type=\"button\" value=\"Boutique\" onclick=\"window.location.href='../index.php'\" />";
        echo "<br/><div style=\"top: 2vw; right: 2vw; position: absolute;\"><form style=\"display: inline-block;\" method=\"POST\" action=\"search.php\" name=\"rechercher1\" role=\"search\"><input type=\"search\" id=\"maRecherche\" name=\"q\" placeholder=\"Rechercher\" size=\"30\"></form>";
        echo " ";
        echo "<input type=\"submit\" value=\"Connexion / Inscription\" onclick=\"window.location.href='accueil.php'\"  /></div>";
        echo "</div>";
        echo "<h2 style=\"text-align: center; margin-top: 5vw;\">Vous vous êtes désinscrit de Prends ton pied</h2>";
		$_SESSION=array(); 
		session_destroy();		
		session_unset();
		echo "<br/><div style=\" text-align: center; margin-top: 2vw; \"><input style=\"\" type=\"button\" value=\"Retourner sur la boutique\" onclick=\"window.location.href='index.php'\" /></div>";
	}
	catch (PDOException $e) {
		echo "Erreur :".$e->getMessage()."<br/>";
		die();
	}
?>