<?php
$database = "agora";
$db_handle = mysqli_connect('localhost', 'root', '');
$db_found = mysqli_select_db($db_handle, $database);

if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!$db_found) {
    die("Database not found");
}

$table = mysqli_real_escape_string($db_handle, $_POST['role']);
echo $table;

$pseudo = mysqli_real_escape_string($db_handle, $_POST['pseudo']);
$prenom = mysqli_real_escape_string($db_handle, $_POST['prenom']);
$nom = mysqli_real_escape_string($db_handle, $_POST['nom']);
$mail = mysqli_real_escape_string($db_handle, $_POST['mail']);
$mdp = mysqli_real_escape_string($db_handle, $_POST['mdp']);

if (empty($prenom) || empty($nom) || empty($pseudo) || empty($mail) || empty($mdp)) {
    echo "<p>Erreur champs vide</p>";
}

$check_sql = "SELECT ID FROM `$table` WHERE Pseudo = '$pseudo'";
$result = mysqli_query($db_handle, $check_sql);

if (mysqli_num_rows($result) > 0) {
    echo "<p>Ce pseudonyme est déjà utilisé.</p>";
}

$sql = "INSERT INTO `$table` (Pseudo, Nom, Prenom, Mail, Mdp) 
            VALUES ('$pseudo', '$nom', '$prenom', '$mail', '$mdp')";
mysqli_query($db_handle,$sql);

echo "Bienvenue ".$pseudo.$nom.$prenom.$mail.$mdp;

mysqli_close($db_handle);
?>