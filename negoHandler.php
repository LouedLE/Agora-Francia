<?php
require_once 'redirect.php';
$db_handle = require __DIR__ . "/coDbb.php";
$id_nego = isset($_GET['id']) ? intval($_GET['id']) : 0;


$sql = "SELECT * FROM `negociation` WHERE `ID` = ".$id_nego;
$result = mysqli_query($db_handle, $sql);
$nego = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $nego = $row;
    }
} else {
    die("Erreur lors de la récupération des info de votre negociation : " . mysqli_error($db_handle));
}
$compteur = $nego['compteur'];
echo $compteur."</br>";
echo $nego['offre']."</br>";
echo $nego['contre_offre']."</br>";
echo $nego['offreFinale']."</br>";


// Si c'est le debut de la negociation
if($compteur == 1){
    $montant = isset($_POST['firstinput']) ? intval($_POST['firstinput']) : 0;
    echo $montant;
}else{
    $montant = isset($_POST['desinput']) ? intval($_POST['desinput']) : 0;
    echo $montant;
}

// pair : tour du vendeur(contre_offre), impair : tour du client (offre)
if($compteur%2==1){
    $offre = "offre";
}else{
    $offre = "contre_offre";
}
echo "</br>".$offre;

$compteur++;
echo "</br>".$compteur;

$sql = "UPDATE negociation SET $offre=$montant, compteur=$compteur WHERE ID=$id_nego";
mysqli_query($db_handle, $sql);

header('Location: parcourir.php');
exit;

?>