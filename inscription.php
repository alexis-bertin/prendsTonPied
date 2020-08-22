<?php 
    session_start(); 
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
 <head>
	<title>INSCRIPTION</title>
	<meta charset="UTF-8">
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
	<h2>Créer un compte</h2>
    <?php if (isset($message)) { echo "<span class='alert'>Champ(s) manquant(s)</span><br/>";} ?>
    <?php if (isset($message2)) { echo "<span class='alert'>Adresse mail déjà utilisée</span>";} ?>
    <?php if (isset($message3)) { echo "<span class='alert'>Les adresses mail ne correspondent pas</span><br/>";} ?>
    <?php if (isset($message4)) { echo "<span class='alert'>Les mots de passe ne sont correspondent pas</span>";} ?>
	<form name="inscription" method="POST" action="ajout.php">
		<table>
		<tr>
    	 <td><span>* Nom </span></td>
    	 <td><input type="text" border='0' size="20" maxlength="30" name="obli[nom]" value="<?php if (isset($_POST['obli'])) {$tab=$_POST['obli']; echo $tab['nom'];} ?>"/><?php if (isset($message5)) { echo "<span class='alert'> Nom incorrect</span>";} ?></td>
    	</tr>
    	<tr>
    	 <td><span>* Prénom </span></td>
    	 <td><input type="text" border='0' size="20" maxlength="30" name="obli[prenom]" value="<?php if (isset($_POST['obli'])) {$tab=$_POST['obli']; echo $tab['prenom'];} ?>"/><?php if (isset($message6)) { echo "<span class='alert'> Prénom incorrect</span>";} ?></td>
    	</tr>
        <tr>
         <td><span>Sexe </span></td>
         <td>
            <select name="sexe">
                <option></option>
                <option>Masculin</option>
                <option>Féminin</option> 
            </select>
        </td>
        </tr>
        <tr>
             <td><span>Date de naissance </span></td>
             <td><input type="date" border='0' size="10" maxlength="10" name="date_naissance" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['date_naissance'];} ?>"/></td>
        </tr>
        <tr>
             <td><span>Téléphone </span></td>
             <td><input type="tel" border='0' size="10" maxlength="10" name="tel" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['tel'];} ?>"/></td>
        </tr>
    	<tr>
    	 <td><span>Code postal </span></td>
    	 <td><input type="text" border='0' size="4" maxlength="5" name="cp" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['cp'];} ?>"/></td>
    	</tr>
    	<tr>
    	 <td><span>Ville </span></td>
    	 <td><input type="text" border='0' size="25" maxlength="30" name="ville" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['ville'];} ?>"/></td>
    	</tr>
        <tr>
         <td><span>Nom de rue </span></td>
         <td><input type="text" border='0' size="25" maxlength="30" placeholder="Rue des Tilleuls" name="norue" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['norue'];} ?>"/></td>
        </tr>
        <tr>
         <td><span>N° rue </span></td>
         <td><input type="text" border='0' size="5" maxlength="10" name="nurue" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['nurue'];} ?>"/></td>
        </tr>
        <tr>
         <td><span>N° appartement </span></td>
         <td><input type="text" border='0' size="5" maxlength="10" name="appart" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['appart'];} ?>"/></td>
        </tr>
    	<tr>
    	 <td><span>* Adresse mail </span></td>
    	 <td><input type="text" border='0' size="40" maxlength="50" name="obli[email]" value="<?php if (isset($_POST['obli'])) {$tab=$_POST['obli']; echo $tab['email'];} ?>"/><?php if (isset($message7)) { echo "<span class='alert'> Adresse mail incorrecte</span>";} ?></td>
    	</tr>
        <tr>
         <td><span>* Vérifier adresse mail </span></td>
         <td><input type="text" border='0' size="40" maxlength="50" name="obli[email2]" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['email2'];} ?>"/></td>
        </tr>
    	<tr>
    	 <td><span>* Mot de passe </span></td>
    	 <td><input type="password" border='0' size="20" maxlength="20" name="obli[mdp]" value=""/><?php if (isset($message8)) { echo "<span class='alert'> Votre mot de passe doit comporter au moins un chiffre, un caractère spécial et 8 caractères ou plus</span>";} ?></td>
    	</tr>
        <tr>
         <td><span>* Répéter mot de passe </span></td>
         <td><input type="password" border='0' size="20" maxlength="20" name="obli[mdp2]" value=""/></td>
        </tr>
		</table>
		<p><input class="red" type="Submit" name="Inscription" value="Créer un compte"></p>
	</form>
 </body>
</html>