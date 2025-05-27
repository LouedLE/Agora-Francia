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

$nomA =  mysqli_real_escape_string($db_handle, $_POST['nom']);
$image = mysqli_real_escape_string($db_handle, $_POST['image']);
$desc = mysqli_real_escape_string($db_handle, $_POST['desc']);
$prix = isset($_POST['prix']) ? (float)$_POST['prix'] : 0;
$rarete = mysqli_real_escape_string($db_handle, $_POST['rarete']);
$type = mysqli_real_escape_string($db_handle, $_POST['type']);


if (empty($nomA) || empty($type) || empty($prix) || empty($rarete)|| empty($desc)) {
    die("Information obligatoire manquante");
}

$check_sql = "SELECT ID FROM article WHERE Nom = '$nomA'";
$result = mysqli_query($db_handle, $check_sql);

if (mysqli_num_rows($result) > 0) {
    die("Cette article existe deja.");
}else{
    $sql= "INSERT INTO `article`(`Nom`, `Image`, `Desc`, `Prix`, `Rarete`, `Type`) VALUES ('$nomA','$image','$desc','$prix','$rarete','$type')";
    mysqli_query($db_handle,$sql);
}

mysqli_close($db_handle);
?>