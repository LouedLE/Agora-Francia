<?php
$db_handle = require __DIR__ . "/coDbb.php";

$table = mysqli_real_escape_string($db_handle, $_POST['role']);
echo $table;

$pseudo = mysqli_real_escape_string($db_handle, $_POST['pseudo']);
$prenom = mysqli_real_escape_string($db_handle, $_POST['prenom']);
$nom = mysqli_real_escape_string($db_handle, $_POST['nom']);
$mail = mysqli_real_escape_string($db_handle, $_POST['mail']);
$mdp = mysqli_real_escape_string($db_handle, $_POST['mdp']);

if (empty($prenom) || empty($nom) || empty($pseudo) || empty($mail) || empty($mdp)) {
    die("Erreur champs vide");
}

$check_sql = "SELECT ID FROM `$table` WHERE Pseudo = '$pseudo'";
$result = mysqli_query($db_handle, $check_sql);

if (mysqli_num_rows($result) > 0) {
    die("Ce pseudonyme est déjà utilisé.");
}

$sql = "INSERT INTO `$table` (Pseudo, Nom, Prenom, Mail, Mdp) 
            VALUES ('$pseudo', '$nom', '$prenom', '$mail', '$mdp')";
mysqli_query($db_handle,$sql);

echo "Bienvenue ".$pseudo;
echo "<a href='connexion.html'>Se connecter</a>";

mysqli_close($db_handle);
?>