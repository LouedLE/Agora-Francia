<?php
require_once 'redirect.php';
$db_handle = require __DIR__ . "/coDbb.php";

$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$offre = isset($_POST['encherir']) ? intval($_POST['encherir']) : 0;

$sql = "SELECT offre FROM enchere WHERE id_article = ".$article_id;
$result = mysqli_query($db_handle, $sql);
$enchere = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $enchere = $row;
    }
} else {
    header("Location: enchere.php?id=".$article_id);
    exit;
}


if($offre < $enchere['offre']){
    header("Location: enchere.php?id=".$article_id);
    exit;
}

$sql = "UPDATE enchere SET offre=".$offre.",id_client=".$_SESSION['user_id']." WHERE id_article=".$article_id;
mysqli_query($db_handle, $sql);
header("Location: enchere.php?id=".$article_id);
exit;
?>