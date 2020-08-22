<?php
require_once("connexions.php");
include("header.inc.php");
 ?>
<form class="formulaire" action="ad.php" method="POST">
  <label> Pseudo : </label>
  <input type="text" name="pseudo">
  <label> mot de passe : </label>
  <input type="password" name="password">
  <button type="submit" name="Envoyer">Envoyer</button>
  <button type="reset" name="Recommencer">Recommencer</button>
</form>
 <?php
include("footer.inc.php");
  ?>
