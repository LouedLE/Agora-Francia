<?php
require_once 'redirect.php';
if($_SESSION['user_table'] == 'client'){
	echo "Reservé aux vendeurs. <a href='parcourir.php'>Retour</a>";
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Agora - notifications</title>
	<link rel="icon" href="images/logo.png" type="image/png">
	<link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="styleParcourir.css">
</head>
<body>
<div class="header">
		<img src="images/logo.png" alt="logo" class="logo">
		<h1>Agora Francia</h1>
	<nav>
		<ul>
			<li><a href="index.php">Accueil</a></li>
			<li><a href="parcourir.php">Tout parcourir</a></li>
			<li><a href="notifications.php">notifications</a></li>
			<li><a href="panier.php">panier</a></li>
			<li><a href="compte.php">votre compte</a></li>
			<li><a href="logout.php">Se deconnecter</a></li>
		</ul>
	</nav>
	</div>
<div style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
<?php
$db_handle = require __DIR__ . "/coDbb.php";


$sql = "SELECT * FROM `negociation` WHERE `id_vendeur`=".$_SESSION['user_id'];
$result = mysqli_query($db_handle, $sql);

$nego = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $nego[] = $row;
    }
} else {
    die("Erreur lors de la récupération des articles : " . mysqli_error($db_handle));
}
foreach ($nego as $row) {
    //echo $row['id_article'] . "<br>";
	$id_article = $row['id_article'];
	//echo $id_article."</br>";
	$id_client = $row['id_client'];
	//echo $id_client."</br>";
	$offreClient = $row['offre'];
	//echo $offreClient."</br>";
	$offreFinale = $row['offreFinale'];
	echo $offreFinale;

	$sql = "SELECT * FROM `client` WHERE ID = ".$id_client;
	$result = mysqli_query($db_handle, $sql);

	$client = [];
	if ($result) {
		while ($r = mysqli_fetch_assoc($result)) {
			$client[] = $r;
		}
	} else {
		die("Erreur lors de la récupération des articles : " . mysqli_error($db_handle));
	}
	$pseudo = $client[0]['Pseudo'];

    $sql = "SELECT * FROM articles WHERE ID = " . $id_article;
    $result = mysqli_query($db_handle, $sql);

    if ($result) {
        while ($article = mysqli_fetch_assoc($result)) {
            echo "<div class='carte'>";
            echo "<img src='{$article['Photo']}' alt='Image de {$article['nom']}'>";
            echo "<h3>{$article['nom']}</h3>";
            echo "<p>{$article['description']}</p>";
            echo "<p><strong>Valeur initiale: {$article['prix']} €</strong></p>";
			echo "<p><strong>Offre du client: {$offreClient} €</strong></p>";
			echo "<h3>Client: {$pseudo}</h3>";
			if($offreFinale==0){
				echo "<a href='negoVendeur.php?idarticle=".$id_article."&idclient=".$id_client."'>Négocier</a>";
			}else{
				echo "<p>Négociation terminée</p>";
				echo "<p><strong>Prix de vente final: {$offreFinale} €</strong></p>";
			}
			echo "</div>";
        }
    } else {
        echo "Erreur lors de la récupération de l'article avec l'ID $id_article : " . mysqli_error($db_handle) . "<br>";
    }
}
mysqli_close($db_handle);
?>
</div>
</body>
</html>