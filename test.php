<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 21/02/2017
 * Time: 3:55 PM
 */

// le lien pour accéder à la page articles avec pagination doit être
//index.php?limite=0

// si limite n'existe pas on l'initialise à zéro
if (empty($_GET['limite'])){ $limite = 0;} else { $limite = intval($_GET['limite']); }

function affichePages($nb,$page,$total) {
    $nbpages=ceil($total/$nb);
    $numeroPages = 1;
    $compteurPages = 1;
    $limite  = 0;

    echo '<table border = "0" ><tr><td>'."Page :</td>";
    while($numeroPages <= $nbpages) {
//css des liens num navigation
        if ( ($_GET['limite'] == 0) AND ( $numeroPages == 1) ){  echo '<td >&nbsp; '.$numeroPages.'</td>'."\n";
        }
        if ( ($_GET['limite'] == 0) AND ( $numeroPages > 1) ){
            echo '<td >&nbsp;<a style="color:red" href = "'.$page.'&limite='.$limite.'">  '.$numeroPages.' </a></td>'."\n";
        }
        if ( ($_GET['limite'] > 0) AND ($_GET['limite'] != $numeroPages) ) {
            echo '<td >&nbsp;<a style="color:red" href = "'.$page.'&limite='.$limite.'">  '.$numeroPages.' </a></td>'."\n";
        }
        elseif ( ($_GET['limite'] > 0) AND ($_GET['limite'] == $numeroPages) ) {  echo '<td >&nbsp;'.$numeroPages.'</td>'."\n";
        }
        $limite = $limite + $nb;
        $numeroPages = $numeroPages + 1;
        $compteurPages = $compteurPages + 1;
        if($compteurPages == 10) {
            $compteurPages = 1;
            echo '<br>'."\n";
        }
    }
    echo '<td>&nbsp;&nbsp;Nbr de pages :('.$nbpages.')</td></tr></table>'."\n";
}


//=========================================

// initialisation des variables

//=========================================

// on va afficher X résultats par page.

$nombre = 10;

// on cherche le nom de la page.

$path_parts = pathinfo($_SERVER['PHP_SELF']);

$page = "index.php?module=articles&action=afficher_art";

//=========================================

// requête SQL qui compte le nombre total

// d'enregistrements dans la table.

//=========================================
   $pdo = PDO2::getInstance();

    $requete = $pdo->prepare("SELECT id FROM articles ");
    $requete->execute();
    $requete->errorInfo();
    $result = $requete->fetchAll();
    $nb = count($result);
    $total = $nb;
echo '<h3>Liste des articles ('.$total.')</h3>';
//=========================================

// connection à la DB

//=========================================

// Create connection
$conn = new mysqli($host, $user, $pass, $bdd);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, titre, texte, note FROM articles ORDER BY id_art LIMIT $limite,$nombre ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        /*option si vous voulez présenter le debut des articles (200 mots)
        $contenu = $row['texte'];
        $text = wordwrap($contenu, 200, "***", true); // insertion de marqueurs ***
        $tcut = explode("***", $text); // on créé un tableau à partir des marqueurs ***
        $part1 = $tcut[0]; // la partie à mettre en exergue (chapeau) avec strong
        $part2 = '';
        for($i=1; $i<count($tcut); $i++) {
            $part2 .= $tcut[$i].' ';
        }
        $part2 = trim($part2); //suppression du dernier espace dans la partie de texte restante
         //la part 1 et en gras (chapeau), la part 2 est le reste du texte en normal
         //echo "<strong>".$part1."</strong> ".$part2; //tout normal supprimer les strong

        echo "".$part1.""; //affiche 200 mots
        echo "... <a href=index.php?module=article&action=article&id=".$voir['id_art'].">Suite &raquo;</a><br />";
        */


        echo ''.$row['titre'].' <br>'.$row['texte'].'<br /><br />';
        if (!empty($row['note'])) { echo '<b>Note(s)</b> '.$row['note'].'<br /> <br/>';} else { echo "";}
    }
} else {
    echo "0 results";
}
$conn->close();

//=========================================

// si le nombre d'enregistrement à afficher

// est plus grand que $nombre

//=========================================

if($total > $nombre) {

    // affichage des liens vers les pages

    affichePages($nombre,$page,$total);

}

?>