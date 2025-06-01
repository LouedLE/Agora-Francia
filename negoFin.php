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

if($compteur%2==1){
    $offreFinale = intval($nego['contre_offre']);
}else{
    $offreFinale = intval($nego['offre']);
}
echo $offreFinale;

$sql = "UPDATE negociation SET offreFinale=$offreFinale WHERE ID=$id_nego";
mysqli_query($db_handle, $sql);

exit;
?>