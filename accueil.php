<?php 
    setcookie('mail_prendstonpied','',time());
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
 <head>
  <meta charset="utf-8" />
  <title>CONNEXION/INSCRIPTION</title>
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
  <h1 style="margin-top: 0;">Connectez-vous ou créez un compte</h1>
  <?php
   session_start();
   session_destroy();		
   session_unset();
  ?>
  <?php if (isset($okMdp)) { echo "<p><span class='alert'>E-mail et/ou mot de passe incorrect(s)</span></p>";} ?>
  <?php if (isset($okMdp2)) { echo "<p><span class='alert'>Veuillez entrer votre e-mail et votre mot de passe</span></p>";} ?>

  <form name="email" method="POST" action="authentification.php">
   <table>
    <tr>
     <td><span>Adresse e-mail </span></td>
     <td><input type="text" border='0' size="50" name="email" value="<?php     if (isset($_COOKIE['mail_prendstonpied'])) {
      echo $_COOKIE['mail_prendstonpied']; 
    } else if (isset($_POST['email'])) {echo $_POST['email'];} ?>"/></td>
    </tr>
    <tr>
     <td><span>Mot de passe </span></td>
     <td><input type="password" border='0' size="50" name="mdp" value=""/></td>
    </tr>
    <tr>
      <td>
        <br/><div>
          <input type="checkbox" id="remember" name="souvenir" <?php     
                                                                  if (isset($_COOKIE['mail_prendstonpied'])) {
                                                                    echo "checked=\"checked\""; 
                                                                  } 
                                                                ?>
          >
          <label for="remember">Se souvenir</label>
        </div>
        <div>
          <input type="checkbox" id="stay" name="stay_c">
          <label for="stay">Rester connecté</label>
        </div>
      </td><td style="text-align: right; text-decoration: none;"><a style="text-decoration: none;" href="reinMdp.php"><br/>Réinitialisation de votre mot de passe</a></td></tr>
   </table><br/>
   <input class="red" type="submit" name="Connexion" value="Se connecter"/> 
   <input class="red" type="submit" name="Inscription" value="Créer un compte"/>
  </form>
 </body>
</html>