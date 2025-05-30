<?php
require_once 'redirect.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<title>Agora - parcourir</title>
	<link rel="icon" href="images/logo.png" type="image/png">
	<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
			background-image: url('images/agora.jpg');
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .ligne {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .carte {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 200px;
            transition: transform 0.2s;
        }

        .carte:hover {
            transform: scale(1.05);
        }

        .carte img {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .carte h3 {
            margin: 10px 0;
            font-size: 16px;
            color: #333;
        }

        .carte p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .carte a {
            display: block;
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 8px;
            border-radius: 4px;
            margin-top: 10px;
            text-decoration: none;
        }

        .carte a:hover {
            background-color: #0056b3;
        }
    </style>
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
<?php
$db_handle = require __DIR__ . "/coDbb.php";

$sql = "SELECT * FROM articles";
$result = mysqli_query($db_handle, $sql);

$articles = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $articles[] = $row;
    }
} else {
    die("Erreur lors de la récupération des articles : " . mysqli_error($db_handle));
}

$types = [
    'rare' => 'Articles Rares',
    'haut_de_gamme' => 'Articles Haut de Gamme',
    'regulier' => 'Articles Réguliers'
];

foreach ($types as $rarete => $titre) {
    echo "<h2>$titre</h2>";
    echo "<div class='ligne'>";
    foreach ($articles as $article) {
        if ($article['rarete'] === $rarete) {
            echo "<div class='carte'>";
            echo "<img src='{$article['Photo']}' alt='Image de {$article['nom']}'>";
            echo "<h3>{$article['nom']}</h3>";
            echo "<p>{$article['description']}</p>";
            echo "<p><strong>{$article['prix']} €</strong></p>";

            if ($article['typeAchat'] === 'achatDirect') {
                echo "<a href='achat_immediat.php?id={$article['ID']}'>Acheter maintenant</a>";
            } elseif ($article['typeAchat'] === 'enchere') {
                echo "<a href='enchere.php?id={$article['ID']}'>Faire une offre</a>";
            } elseif ($article['typeAchat'] === 'transaction') {
                echo "<a href='negociation.php?id={$article['ID']}'>Négocier</a>";
            }

            echo "</div>";
        }
    }
    echo "</div>";
}

mysqli_close($db_handle);
?>
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