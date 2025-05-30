<?php
require_once 'redirect.php';
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
</br>
<?php
$db_handle = require __DIR__ . "/coDbb.php";
$check_sql = "SELECT * FROM ".$_SESSION["user_table"]." WHERE ID =". $_SESSION['user_id'];
$result = mysqli_query($db_handle, $check_sql);
$compte = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $compte = $row;
    }
} else {
    die("Erreur lors de la récupération des info de votre compte : " . mysqli_error($db_handle));
}
?>
	<div class="profile-container" style="background-image: url('<?php echo isset($compte['imageFond']) ? htmlspecialchars($compte['imageFond']) : ''; ?>')">
			<div class="profile-header">
				<h1 class="profile-name"><?php echo htmlspecialchars($compte["Prenom"] . ' ' . $compte["Nom"]); ?></h1>
				<h2 class="profile-pseudo"><?php echo htmlspecialchars($compte["Pseudo"]); ?></h2>
			</div>
			
			<div class="profile-details">
				<div class="detail-card">
					<div class="detail-label">Email</div>
					<div><?php echo htmlspecialchars($compte["Mail"]); ?></div>
				</div>
				
				<div class="detail-card">
					<div class="detail-label">Mot de passe</div>
					<div><?php echo htmlspecialchars($compte["Mdp"]); ?></div>
				</div>
				<div class="detail-card">
					<div>
					<?php
						if($_SESSION["user_table"] == "vendeur"){
							echo "<div class='detail-label'>Ajouter un article</div>";
							echo "<a class='change-bg-btn' href='nvArticle.html'>Poster un nouvel article</a>";
						}
					?>
					</div>
				</div>
			</div>
			
			<button class="change-bg-btn" onclick="window.location.href='imgFond.html'">
				Changer l'image de fond
			</button>
	</div>
	<div class="footer">
		<div class="footer-content">
			<div class="footer-contact">
				<h3>Contactez-nous</h3>
				<p><strong>Email :</strong> <a href="mailto:louisedouard.lebeldepenguilly@edu.ece.fr">louisedouard.lebeldepenguilly@edu.ece.fr</a></p>
				<p><strong>Téléphone :</strong> 06 15 91 39 05</p>
				<p><strong>Adresse :</strong> 10 Rue Sextius-Michel, 75015 Paris</p>
			</div>
			<div class="footer-map">
				<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d42007.61881544458!2d2.288582542327897!3d48.849129597134294!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6701b4f581a8f%3A0xcc038371dc7bf603!2s10%20Rue%20Sextius%20Michel%2C%2075015%20Paris!5e0!3m2!1sfr!2sfr!4v1748276552561!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>
		</div>
	</div>
</body>
</html>