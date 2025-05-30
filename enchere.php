<?php
require_once 'redirect.php';
$db_handle = require __DIR__ . "/coDbb.php";
date_default_timezone_set('Europe/Paris');

if($_SESSION['user_table'] != 'client'){
	die("Vous devez être connecté avec un compte client pour pouvoir accéder aux enchères. <a href='parcourir.php'>Retour</a>");
}

$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM articles WHERE ID = ".$article_id;
$result = mysqli_query($db_handle, $sql);
$article = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $article = $row;
    }
} else {
    die("Erreur lors de la récupération des info de votre article : " . mysqli_error($db_handle));
}

$sql = "SELECT * FROM enchere WHERE id_article = ".$article_id;
$result = mysqli_query($db_handle, $sql);
$enchere = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $enchere = $row;
    }
} else {
    die("Erreur lors de la récupération des info de votre enchere : " . mysqli_error($db_handle));
}


$sql = "SELECT * FROM vendeur WHERE ID = ".$enchere['id_vendeur'];
$result = mysqli_query($db_handle, $sql);
$vendeur = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $vendeur = $row;
    }
} else {
    die("Erreur lors de la récupération des info de votre vendeur : " . mysqli_error($db_handle));
}

$sql = "SELECT * FROM client WHERE ID = ".$enchere['id_client'];
$result = mysqli_query($db_handle, $sql);
$client = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $client = $row;
    }
} else {
    die("Erreur lors de la récupération des info de votre vendeur : " . mysqli_error($db_handle));
}
echo $enchere['dateFin'];
$cloture = new DateTime($enchere['dateFin']);
$now = new DateTime();
echo "Date actuelle : " . $now->format('Y-m-d H:i:s') . "</br>";
echo "Date de clôture : " . $cloture->format('Y-m-d H:i:s') . "</br>";
if($now > $cloture){
	echo "Fin des enchères pour cette article, merci de votre participation.</br>";
	echo $client['Pseudo']." remporte un(e) ".$article['nom']." pour un montant de ".$enchere['offre']." €.</br>";
	$sql = "DELETE FROM `enchere` WHERE `enchere`.`id_article`=".$article_id;
	$r = mysqli_query($db_handle, $sql);
	if($r){
		echo "Article supprimé de la base de données avec succès.</br>";
	}else{
		echo "Problème avec la suppression de l'article";
	}
	$sql = "DELETE FROM `articles` WHERE `articles`.`ID` =".$article_id;
	$r = mysqli_query($db_handle, $sql);
	if($r){
		echo "Article supprimé de la base de données avec succès.</br>";
	}else{
		echo "Problème avec la suppression de l'article</br>";
	}
	echo "<a href='parcourir.php'>Rechercher d'autres articles</a>";
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Agora - espace perso</title>
	<link rel="icon" href="images/logo.png" type="image/png">
	<link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" href="styleProfil.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<script>
		function encherir() {
			var inputEncherir = document.getElementById("inputEncherir");
			inputEncherir.style.display = "block";
		}
    </script>
	
</head>
<div class="profile-container" style="background-image: url('<?php echo isset($article['Photo']) ? htmlspecialchars($article['Photo']) : ''; ?>')">
			
			
			<div class="profile-details">
				<div class="profile-header">
					<h1 class="profile-name"><?php echo "Auteur: ".$vendeur['Pseudo']; ?></h1>
					<h2 class="profile-pseudo"><?php echo "Nom: ".$article['nom']; ?></h2>
					<h2 class="profile-pseudo"><?php echo "Rareté: ".$article['rarete'].", Type: ".$article['Type']; ?></h2>
				</div>
				<div class="detail-card">
					<div class="detail-label">Description</div>
					<div><?php echo htmlspecialchars($article["description"]); ?></div>
				</div>
				
				<div class="detail-card">
					<div class="detail-label">Valeur</div>
					<div><?php echo htmlspecialchars($article["prix"]); ?></div>
				</div>
				<div class="detail-card">
					<div class="detail-label">Cloture de l'offre</div>
					<div><?php echo htmlspecialchars($enchere["dateFin"]); ?></div>
				</div>
				<div class="detail-card">
					<div class="detail-label">Dernière offre</div>
					<div><?php echo htmlspecialchars($enchere["offre"]); ?></div>
				</div>
				<div class="detail-card">
					<div class="detail-label">Auteur de la dernière offre</div>
					<div><?php echo isset($client['Pseudo']) ? htmlspecialchars($client['Pseudo']) : 'Aucune offre'; ?></div>
				</div>
				<div class="detail-card" id="inputEncherir" style="display: none;">
					<div class="detail-label">Surenchérir</div>
					<form action="surencherir.php?id=<?php echo $article_id; ?>" method="post">
						<input style="background-color: rgba(0, 0, 0, 0.9);" type="number" id="encherir" name="encherir" min=<?php echo $enchere["offre"]+1; ?> required>
						<button class="change-bg-btn" type="submit">Valider</button>
					</form>
            	</div>
			</div>
			
			<button class="change-bg-btn" onclick="encherir()">
				Enchérir
			</button>
			<a class="change-bg-btn" href="parcourir.php">Retour vers l'Agora</a>
	</div>
</html>