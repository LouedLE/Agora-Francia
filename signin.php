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

$pseudo = mysqli_real_escape_string($db_handle, $_POST['pseudo']);
$mdp = mysqli_real_escape_string($db_handle, $_POST['mdp']);

if (empty($pseudo) || empty($mdp)) {
    die("Erreur champs vide");
}

$check_sql = "SELECT ID FROM `$table` WHERE Pseudo = '$pseudo' AND Mdp = '$mdp'";
$result = mysqli_query($db_handle, $check_sql);
$user = $result->fetch_assoc();

if (mysqli_num_rows($result) > 0) {
    session_start();
    echo "Bienvenue ".$pseudo." !";
    session_regenerate_id();

    
    $_SESSION["user_id"] = $user["ID"];
    
    echo "<a href='index.php'>Vers l'Agora</a>";
}else{
    die("Mauvais pseudo ou mot de passe.");
}

mysqli_close($db_handle);
?>