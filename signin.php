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
$mdp = mysqli_real_escape_string($db_handle, $_POST['mdp']);

if (empty($pseudo) || empty($mdp)) {
    echo "<p>Erreur champs vide</p>";
}

$check_sql = "SELECT ID FROM `$table` WHERE Pseudo = '$pseudo' AND Mdp = '$mdp'";
$result = mysqli_query($db_handle, $check_sql);

if (mysqli_num_rows($result) > 0) {
    echo "<p>Bienvenue ".$pseudo."</p>";
}else{
    echo "<p>Mauvais pseudo ou mot de passe.</p>";
}

mysqli_close($db_handle);
?>