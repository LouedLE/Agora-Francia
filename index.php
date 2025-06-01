<?php
require_once 'redirect.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Agoria Francia</title>
	<link rel="icon" href="images/logo.png" type="image/png">
	<link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<style>
		h2 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 20px;
        }
	</style>
</head>
<body style="background-image: url('images/agora.jpg');">
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
	<h2>Sélections du jour</h2>
	<div class="selection">
		<div class="image-selection">
			<img src="images/selection1.png" alt="meuble">
		</div>
		<div class="image-selection">
			<img src="images/selection2.png" alt="portrait">
		</div>
		<div class="image-selection">
			<img src="images/selection3.png" alt="bijoux">
		</div>
		<div class="image-selection">
			<img src="images/selection4.png" alt="statue">
		</div>
		<div class="image-selection">
			<img src="images/selection5.png" alt="meuble">
		</div>
		<div class="image-selection">
			<img src="images/selection6.png" alt="portrait">
		</div>
		<div class="image-selection">
			<img src="images/selection7.png" alt="bijoux">
		</div>
		<div class="image-selection">
			<img src="images/selection8.png" alt="statue">
		</div>
		<div class="image-selection">
			<img src="images/selection9.png" alt="bijoux">
		</div>
		<div class="image-selection">
			<img src="images/selection10.png" alt="statue">
		</div>
	</div>>
	<div class="container">
		<h2>Découvrez nos produits !</h2>
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Indicateurs -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
				<li data-target="#myCarousel" data-slide-to="3"></li>
			</ol>

			<div class="carousel-inner">
				<div class="item active">
					<img src="images/oeuvre1.jpg" alt="meuble">
				</div>

				<div class="item">
					<img src="images/oeuvre2.jpg" alt="portrait">
				</div>

				<div class="item">
					<img src="images/oeuvre3.jpg" alt="bijoux">
				</div>

				<div class="item">
					<img src="images/oeuvre4.jpeg" alt="statue">
				</div>
			</div>

			<!-- Contrôles à gauche et à droite -->
			<a class="left carousel-control" href="#myCarousel" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
				<span class="sr-only">Précédent</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
				<span class="sr-only">Suivant</span>
			</a>
		</div>
	</div>
	<br>
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