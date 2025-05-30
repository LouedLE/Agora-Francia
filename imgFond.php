<?php
require_once 'redirect.php';
$db_handle = require __DIR__ . "/coDbb.php";

if(!isset($_FILES['image'])){
    echo "FICHIER DE MOINS DE 2 MO .jpg .jpeg .png ou .gif OBLIGATOIRE";
    exit;
}

if(isset($_FILES['image'])){
// Dossier de destination pour les uploads
    $uploadDir = 'imgFondProfil/';
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
    echo $fileName.$fileTmpName.$fileSize.$fileError.$fileType;

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

$check_sql = "SELECT ID FROM ".$_SESSION['user_table']." WHERE ID =". $_SESSION['user_id'];
$result = mysqli_query($db_handle, $check_sql);
$compte = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $compte = $row;
    }
} else {
    die("Erreur lors de la récupération des info de votre compte : " . mysqli_error($db_handle));
}

if (mysqli_num_rows($result) > 0) {
    $sql = "UPDATE ".$_SESSION['user_table']." SET imageFond = '".$imagePath."' WHERE ".$_SESSION['user_table'].".`ID` = ".$compte['ID']."";
    mysqli_query($db_handle, $sql);
    echo "Fond d'écran mis à jour.";
    //echo "<a class='change-bg-btn' href='compte.php'>Retour</a>";
    echo '<script type="text/javascript">
        window.location.href = "compte.php";
      </script>';
    exit;
}else{
    die("Probleme");
}

mysqli_close($db_handle);
?>