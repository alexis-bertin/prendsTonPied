<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
        $( document ).ready(function(){
            $( '#button1' ).on('click',function(){
                $( '#myform' ).show();
                $( '#myform2' ).hide();
                $( '#myform3' ).hide();
                $( '#add' ).show();
                $( '#modify' ).hide();
                $( '#delete' ).hide();
            });
            $( '#button2' ).on('click',function(){
                $( '#myform' ).hide();
                $( '#myform2' ).show();
                $( '#myform3' ).hide();
                $( '#add' ).hide();
                $( '#modify' ).show();
                $( '#delete' ).hide();
            });
            $( '#button3' ).on('click',function(){
                $( '#myform' ).hide();
                $( '#myform2' ).hide();
                $( '#myform3' ).show();
                $( '#add' ).hide();
                $( '#modify' ).hide();
                $( '#delete' ).show();
            });
            $("#modeleSelect").hide();
            $("#modeleLabelChoice").hide();
            $.ajax({
                url: "http://prendstonpied.fr/Admin/getMarque.php",
                type: "GET",
                error: function() {
                    $('#info').html('<p>Une erreur est survenue</p>');
                },
                success:function(){
                    var nodesMarques = document.getElementsByName('Marque');    
                    var output = "<option value=";              
                    var i;              
                    for (i=0 ; i<nodesMarques.length ; i++) {
                            var nodeMarque = nodesMarques[i];
                            var Marque=nodeMarque.firstChild.nodeValue;     
                            var valueMarque=nodeMarque.getAttribute("id");  
                            output+="\""+valueMarque+"\">"+Marque+"</option>\n";
                    }           
                    $("#MarqueSelect").append(output);                              
                }
                }
            )
            });
            function changementMarque(){
                $("#info").hide();
                $("#modeleSelect").show();
                $("#modeleLabelChoice").show();
                var selectedMarque=$("#MarqueSelect").val();
                if(!selectedMarque) {
                    $("#modeleSelect").hide();
                    $("#modeleLabelChoice").hide();
                }
                else {
                    $.get("http://prendstonpied.fr/Admin/getModele.php",
                        {"MarqueCode": selectedMarque},
                        function(){
                            var nodeModele = document.getElementsByName('modele');  
                            var output = "<option value=''></option>";              
                            var i;              
                            for (i=0 ; i<nodeModele.length ; i++) {
                                    var nodeMod = nodeModele[i];
                                    var mod=nodeMod.firstChild.nodeValue;       
                                    var valueMod=nodeMod.getAttribute("id");    
                                    output+="<option value=\""+valueMod+"\">"+mod+"</option>\n";
                            }           
                            $("#modeleSelect").html(output);
                        },
                        "xml"
                    );
                }   
            }
            function changementmodele(){
                var selectedDept=$("#modeleSelect").val();
                if(!selectedDept) return;
                else {
                    $("#info").show();
                    $.getJSON("http://prendstonpied.fr/Admin/getModele.php",
                        {"modeleName":selectedModele},
                        function(result){
                            var s={"nomModele":"Modèle : ", "nomMarque": "Marque : "};
                            var output = "";
                            for(var key in s){
                                var texte = s[key];
                                var value= result[key];
                                output += "<p> "+texte+value+"</p>";
                            }                                                       
                            $("#info").html(output);
                        }
                    );
                }
            };
        </script>
        <title>Prends ton pied</title>
    </head>
    <body>
    <?php
    $user='dbo674212202';
    $mdp='Alex040698';
    $dsm="mysql:host=db674212202.db.1and1.com;dbname=db674212202";
    try {
        $cx=new PDO($dsm,$user,$mdp);
        $cx->exec('SET NAMES utf8');
        $cx->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        echo "ERREUR :".$e->getMessage()."<br/>";
        die();
    }
    ?>

        <button id="button1">Ajouter un produit</button>
        <button id="button2">Modifier un produit</button>
        <button id="button3">Supprimer un produit</button>

        <div id="myform" style="display: none;">
        	<form name="Ajouter" method="POST" enctype="multipart/form-data" id="interface">
        		<table>
            		<tr>
                	 <td><span>* Marque </span></td>
                	 <td><input type="text" border='0' size="20" maxlength="30" name="obli[marque]" value="<?php if (isset($_POST['obli'])) {$tab=$_POST['obli']; echo $tab['marque'];} ?>"/><?php if (isset($message5)) { echo "<span class='alert'> Nom de marque incorrect</span>";} ?></td>
                	</tr>
                	<tr>
                	 <td><span>* Modèle </span></td>
                	 <td><input type="text" border='0' size="20" maxlength="30" name="obli[modele]" value="<?php if (isset($_POST['obli'])) {$tab=$_POST['obli']; echo $tab['model'];} ?>"/><?php if (isset($message6)) { echo "<span class='alert'> Nom de modele incorrect</span>";} ?></td>
                	</tr>
                    <tr>
                     <td><span>* Poids</span></td>
                     <td><input type="text" border='0' size="20" maxlength="30" name="obli[poids]" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['poids'];} ?>"/></td>
                    </tr>
                    <tr>
                     <td><span>* Image</span></td>
                     <td><input type="file" border='0' size="50" maxlength="30" name="obli[img]" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['poids'];} ?>"/></td>
                      <td><input type="hidden" name="MAX_FILE_SIZE" value="1048576"/></td>
                    </tr>
                    <tr>
                        <td><span>* Course </span></td>
                        <td>
                        <select name="obli[course]">
                            <option>Asphalte</option>
                            <option>Piste</option>
                            <option>Chemin</option> 
                            <option>Toutes</option>
                        </select>
                        </td>
                    </tr>
                     <tr>
                     <td><span>* Foulée </span></td>
                     <td>
                        <select name="obli[foulée]">
                            <option>Universel</option>
                            <option>Pronateur</option>
                            <option>Supinateur</option> 
                        </select>
                    </td>
                    </tr>
                    <tr>
                     <td><span>* Sexe </span></td>
                     <td>
                        <select name="obli[sexe]">
                            <option></option>
                            <option>Masculin</option>
                            <option>Féminin</option> 
                        </select>
                    </td>
                    </tr> 
                    <tr>
                         <td><span>* Prix </span></td>
                         <td><input type="number" border='0' size="10" maxlength="10" name="obli[prix]" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['prix'];} ?>"/></td>
                    </tr>
                    <tr>
                     <td><span>Promotion</span></td>
                     <td><input type="text" border='0' size="20" maxlength="30" name="promotion" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['promotion'];} ?>"/></td>
                    </tr>
                </table>
            </form>
            <table>
                <tr>
                    <td><span>Description </span></td>
                    <td><textarea form="interface" border='0' cols="25" rows="5" name="description" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['description'];} ?>"/></textarea></td>
                </tr>
            </table>
            <form>
                <p><input id="add" type="Submit" name="Ajout" value="Ajouter"></p>
            </form>
        </div>
        <div id="myform2" style="display: none;">
            <form method="GET">
            <fieldset>
                <legend>Liste Ajax Marque/Modèle</legend>
                <label>Choisissez votre Marque: </label>
                <select id="MarqueSelect" name="Marque" onchange="changementMarque()">              
                </select>
                <label id="modeleLabelChoice">Choisissez votre Modèle: </label>
                <select id="modeleSelect" name="modele" onchange="changementmodele()">              
                </select>
            </fieldset>
            </form> 
            <div id="info"></div>
            <form>
                <p><input id="modifier" type="Submit" name="Ajout" value="Modifier"></p>
            </form>
        </div>
        <div id="myform4" style="display: none;">
            <?php
            $_POST['marque']=$marque;
            $_POST['modele']=$modele;
                $sql="SELECT * FROM Chaussures WHERE marque ='$marque'AND modele='$modele' ";
                $prep=$cx->prepare($sql);
                $tabVal=array(':marque'=>$marque,':modele'=>$modele);
                $res=$prep->execute($tabVal);
                while ($ligne=$prep->fetch(PDO::FETCH_OBJ)) {
                    $id=$ligne->id_chaussure;
                    $marque=$ligne->marque;
                    $modele=$ligne->modele;
                    $poids=$ligne->poids;
                    $img=$ligne->img_chaussure;
                    $course=$ligne->type_course;
                    $foulee=$ligne->type_foulee;
                    $sexe=$ligne->Sexe;
                    $prix=$ligne->Prix;
                    $description=$ligne->Description;
                    $nb_achat=$ligne->nb_achat_C;
                    $promotion=$ligne->promotion;
                    $date_d=$ligne->date_depot;
                    echo "<p><h2>INFO Chaussures</h2></p>";
                    echo "<form style=\"margin-bottom:16px;\" name=\"modif\" method=\"POST\" action=\"modifInfos.php\">";
                    echo "<table>
                            <tr><td>Marque : </td><td><input name=\"marque\" type=\"text\" value=".$marque."></input></td></tr>
                            <tr><td>Modèle : </td><td><input name=\"modele\" type=\"text\" value=".caseVide($modele)."></input></td></tr>
                            <tr><td>Poids: </td><td><input name=\"poids\" type=\"text\" value=".caseVide($poids)."></input></td></tr>
                            <tr><td>Image : </td><td><input name=\"img\" type=\"text\" value=".caseVide($img)."></input></td></tr>
                            <tr><td>Course : </td><td><input name=\"course\" type=\"text\" value=".caseVide($course)."></input></td></tr>
                            <tr><td>Foulée : </td><td><input name=\"foulee\" type=\"text\" value=\"".caseVide($foulee)."\"></input></td></tr>
                            <tr><td>Sexe : </td><td><input name=\"sexe\" type=\"text\" value=".caseVide($sexe)."></input></td></tr>
                            <tr><td>Prix : </td><td><input name=\"prix\" type=\"text\" value=\"".caseVide($prix)."\"></input></td></tr>
                            <tr><td>Description : </td><td><input name=\"description\" type=\"text\" value=".caseVide($description)."></input></td></tr>
                             <tr><td>Promotion : </td><td><input name=\"promo\" type=\"text\" value=".caseVide($promotion)."></input></td></tr></table>";
                }
                ?>
            <form>
                <p><input id="modify" type="Submit" name="Ajout" value="Modifier" action="modifChaussure.php"></p>
            </form>
        </div>
        <div id="myform3" style="display: none;">
            <form name="inscription" method="POST" action="supChaussure.php" enctype="multipart/form-data" id="interface">
                <table>
                    <tr>
                     <td><span>* Marque </span></td>
                     <td><input type="text" border='0' size="20" maxlength="30" name="obli[marque]" value="<?php if (isset($_POST['obli'])) {$tab=$_POST['obli']; echo $tab['marque'];} ?>"/><?php if (isset($message5)) { echo "<span class='alert'> Nom de marque incorrect</span>";} ?></td>
                    </tr>
                    <tr>
                     <td><span>* Modèle </span></td>
                     <td><input type="text" border='0' size="20" maxlength="30" name="obli[modele]" value="<?php if (isset($_POST['obli'])) {$tab=$_POST['obli']; echo $tab['model'];} ?>"/><?php if (isset($message6)) { echo "<span class='alert'> Nom de modele incorrect</span>";} ?></td>
                    </tr>
                    <tr>
                     <td><span>Poids</span></td>
                     <td><input type="text" border='0' size="20" maxlength="30" name="poids" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['poids'];} ?>"/></td>
                    </tr>
                    <tr>
                     <td><span>Image</span></td>
                     <td><input type="file" border='0' size="50" maxlength="30" name="img" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['poids'];} ?>"/></td>
                      <td><input type="hidden" name="MAX_FILE_SIZE" value="1048576"/></td>
                    </tr>
                     <tr>
                     <td><span>Course </span></td>
                     <td>
                        <select name="course">
                            <option>Asphalte</option>
                            <option>Piste</option>
                            <option>Chemin</option> 
                            <option>Toutes</option>
                        </select>
                    </td>
                    </tr>
                     <tr>
                     <td><span>Foulée </span></td>
                     <td>
                        <select name="foulée">
                            <option>Universel</option>
                            <option>Pronateur</option>
                            <option>Supinateur</option> 
                        </select>
                    </td>
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
                         <td><span>Prix </span></td>
                         <td><input type="number" border='0' size="10" maxlength="10" name="prix" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['prix'];} ?>"/></td>
                    </tr>
                    <tr>
                     <td><span>Promotion</span></td>
                     <td><input type="text" border='0' size="20" maxlength="30" name="promotion" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['promotion'];} ?>"/></td>
                    </tr>
                </table>
            </form>
            <table>
                <tr>
                    <td><span>Description </span></td>
                    <td><textarea form="interface" border='0' cols="25" rows="5" name="description" value="<?php if (isset($_POST['obli'])) {$tab=$_POST; echo $tab['description'];} ?>"/></textarea></td>
                </tr>
            </table>
            <form>
                <p><input id="delete" type="Submit" name="Ajout" value="Supprimer"></p>
            </form>
        </div>
    </body>
</html>