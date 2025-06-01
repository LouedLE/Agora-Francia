<?php
require_once 'redirect.php';
$db_handle = require __DIR__ . "/coDbb.php";

if(!isset($_FILES['image'])){
    echo "FICHIER DE MOINS DE 2 MO .jpg .jpeg .png ou .gif OBLIGATOIRE";
    exit;
}

if(isset($_FILES['image'])){
// Dossier de destination pour les uploads
    $uploadDir = 'imgArticle/';
    // Créer le dossier s'il n'existe pas
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Informations sur le fichier uploadé
    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];

    // Extraire l'extension du fichier
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Extensions autorisées
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    // Vérifier l'extension
    if (in_array($fileExt, $allowedExtensions)) {
        // Vérifier les erreurs d'upload
        if ($fileError === 0) {
            // Vérifier la taille du fichier (max 5MB)
            if ($fileSize < 5000000) {
                // Générer un nom unique pour éviter les conflits
                $newFileName = uniqid('', true) . '.' . $fileExt;
                $fileDestination = $uploadDir . $newFileName;

                // Déplacer le fichier uploadé
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $imagePath = mysqli_real_escape_string($db_handle, $fileDestination);
                } else {
                    echo "Erreur lors du déplacement du fichier";
                    exit;
                }
            } else {
                echo "Fichier trop volumineux (max 5MB)";
                exit;
            }
        } else {
            echo "Erreur lors de l'upload du fichier (supérieur à 2 Mo) ";
            exit;
        }
    } else {
        echo "Type de fichier non autorisé. Formats acceptés: " . implode(', ', $allowedExtensions);
        exit;
    }
}
$nomA =  mysqli_real_escape_string($db_handle, $_POST['nom']);
//$image = mysqli_real_escape_string($db_handle, $_POST['image']);
$desc = mysqli_real_escape_string($db_handle, $_POST['desc']);
$prix = isset($_POST['prix']) ? (float)$_POST['prix'] : 0;
$rarete = mysqli_real_escape_string($db_handle, $_POST['rarete']);
$type = mysqli_real_escape_string($db_handle, $_POST['type']);
$typeAchat = mysqli_real_escape_string($db_handle, $_POST['typeAchat']);
if($typeAchat === 'enchere'){
    $dateFin = isset($_POST['dateFin']) ? $_POST['dateFin'] : null;
    if($dateFin){
        $dateTimeObject = new DateTime($dateFin);
        $dateFinString = $dateTimeObject->format('Y-m-d H:i:s');
    }else{
        die("Probleme avec la date");
    }
}

if (empty($nomA) || empty($type) || empty($prix) || empty($rarete)|| empty($desc)) {
    die("Information obligatoire manquante");
}

$check_sql = "SELECT ID FROM articles WHERE nom = '$nomA'";
$result = mysqli_query($db_handle, $check_sql);

if (mysqli_num_rows($result) > 0) {
    die("Cet article existe deja.");
}else{
    $sql= "INSERT INTO `articles`(`nom`, `description`, `Type`, `prix`, `rarete`, `typeAchat`, `Photo`, `id_vendeur`) VALUES ('$nomA','$desc','$type','$prix','$rarete','$typeAchat','$imagePath',".intval($_SESSION['user_id']).")";
    mysqli_query($db_handle,$sql);
    if($typeAchat == 'enchere'){
        $sql = "SELECT `ID` FROM `articles` WHERE `nom`='".$nomA."'";
        $result = mysqli_query($db_handle, $sql);
        $article = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $article = $row;
            }
        } else {
            die("Erreur lors de la récupération des info de votre article : " . mysqli_error($db_handle));
        }
        $sql = "INSERT INTO `enchere`(`id_article`, `dateFin`, `id_vendeur`, `valeur`) VALUES (".$article['ID'].", '".$dateFinString."', ".$_SESSION['user_id'].", ".$prix.")";
        mysqli_query($db_handle, $sql);
    }
    echo $nomA . " enregistré dans la base de données avec succès.</br> <a href='parcourir.php'>Vers Agora</a> </br> <a href='nvArticle.html'>Poster un autre article</a>";
    exit;
}

mysqli_close($db_handle);
?>