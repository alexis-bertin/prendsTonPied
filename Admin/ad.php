<?php
  require_once("connexions.php");
  $pseudo= htmlentities($_POST["pseudo"]);
  $password = htmlentities($_POST["password"]);
  $GLOBALS['bool'] = false;

if(!empty($pseudo) && !empty($password)){

  if(getUser($pseudo, $password)){
    $GLOBALS['bool']=true;
    include("config.php");
  }
  else{
    echo "Vous n'êtes pas autorisé à venir jouer avec nous LOL";
  }
}

function getUser($id, $mdp){
  PDOConnexion::setParameters("db716067759", "dbo716067759", "w8198-56472rtW");
  $db= PDOConnexion::getInstance();
  $sql="SELECT * FROM aube WHERE pseudo=:id AND password=:mdp";
  $sth=$db-> prepare($sql);
  $sth -> execute(array(":id"=>$id, ":mdp"=>$mdp));
  $resultat = $sth -> fetch();
  return $resultat;
}
 ?>
