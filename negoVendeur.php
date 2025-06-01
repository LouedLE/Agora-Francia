<?php
require_once 'redirect.php';
$db_handle = require __DIR__ . "/coDbb.php";

$article_id = isset($_GET['idarticle']) ? intval($_GET['idarticle']) : 0;
$client_id = isset($_GET['idclient']) ? intval($_GET['idclient']) : 0;

if($_SESSION['user_table'] == 'client'){
	header("Location: parcourir.php");
    exit;
}
echo "id client:".$client_id;
echo "</br>id article: ".$article_id;

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

$sql = "SELECT * FROM vendeur WHERE ID = ".$article['id_vendeur'];
$result = mysqli_query($db_handle, $sql);
$vendeur = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $vendeur = $row;
    }
} else {
    die("Erreur lors de la récupération des info de votre vendeur : " . mysqli_error($db_handle));
}
echo "</br> pseudo vendeur: ".$vendeur['Pseudo'];


$sql = "SELECT * FROM `negociation` WHERE `id_article`=$article_id AND `id_client`=$client_id";
$result = mysqli_query($db_handle, $sql);
$nego = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $nego = $row;
    }
} else {
    die("Erreur lors de la récupération des info de votre client : " . mysqli_error($db_handle));
}

$sql = "SELECT * FROM client WHERE ID = ".$nego['id_client'];
$result = mysqli_query($db_handle, $sql);
$client = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $client = $row;
    }
} else {
    die("Erreur lors de la récupération des info de votre client : " . mysqli_error($db_handle));
}
echo $client['Pseudo'];

//Si la négo n'existe pas création d'une nvl ligne dans la table negociation
if (empty($nego)) {
    echo "</br>Cette transaction n'existe pas.";
    exit;
}

echo "</br>".$nego['ID'];

//$sql ="INSERT INTO `negociation`(`id_article`, `id_vendeur`, `id_client`, `offre`, `contre_offre`, `offreFinale`, `compteur`) 
//VALUES (')";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Transaction</title>
	<link rel="icon" href="images/logo.png" type="image/png">
	<link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" href="styleProfil.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<script>
		function non() {
			var input = document.getElementById("desinput");
			input.style.display = "block";
            var inputlabel = document.getElementById("desinputlabel");
			inputlabel.style.display = "block";
            var submit = document.getElementById("valider");
			submit.style.display = "block";
		}
    </script>
	
</head>
<div class="profile-container" style="background-image: url('<?php echo isset($article['Photo']) ? htmlspecialchars($article['Photo']) : ''; ?>')">
			
			
			<div class="profile-details">
				<div class="profile-header">
					<h1 class="profile-name"><?php echo "Client: ".$client['Pseudo']; ?></h1>
					<h2 class="profile-pseudo"><?php echo "Nom: ".$client['Nom']; ?></h2>
					<h2 class="profile-pseudo"><?php echo $article['nom']; ?></h2>
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
					<div class="detail-label">offre</div>
					<div><?php echo $nego['offre']; ?></div>
				</div>
				<div class="detail-card">
					<div class="detail-label">contre offre</div>
					<div><?php echo $nego['contre_offre']; ?></div>
				</div>
				<div 
                class="detail-card"
                style="display: <?php echo ($nego['offreFinale']==0) ? 'none' : 'block'; ?>;"
                >
					<div class="detail-label">offre Finale</div>
					<div><?php echo $nego['offreFinale']; ?></div>
				</div>
                
                
                <div 
                class="detail-card" 
                id="inputEncherir" 
                style="display: <?php echo ($nego['offreFinale']==0) ? 'block' : 'none'; ?>;"
                >
                    
                    <div 
                    class="detail-label"
                    style="display: <?php echo ($nego['compteur']%2 == 1) ? 'block' : 'none'; ?>;"
                    >En attente de la réponse du client...</div>

                    <form 
                    action="negoHandler.php?id=<?php echo intval($nego['ID']); ?>" 
                    method="post" 
                    style="display: <?php echo ($nego['compteur'] % 2 == 0) ? 'block' : 'none'; ?>;"
                    >
                        <div
                        id="desinputlabel"
                        class="detail-label"
                        style="display: none;"
                        >Proposez une autre offre</div>
                        <input
                            class="change-bg-btn"
                            style="background-color: rgba(8, 167, 0, 0.9); display: none;"
                            type="number" id="desinput" name="desinput" min="1"
                        >
                        <button class="change-bg-btn" type="submit" id="valider" style="display: <?php echo ($nego['compteur'] == 0) ? 'block' : 'none'; ?>;">Valider</button>
                    </form>
                </div>
                <div 
                class="detail-card"
                style="display: <?php echo ($nego['offreFinale']==0) ? 'block' : 'none'; ?>;"
                >
                    <div 
                        class="detail-label"
                        style="display: <?php echo ($nego['compteur'] > 1 && $nego['compteur'] % 2 == 0) ? 'block' : 'none'; ?>;"
                        >Acceptez-vous la contre offre du client ?</div>
                    <button
                        class="change-bg-btn"
                        onclick="window.location.href='negoFin.php?id=<?php echo intval($nego['ID']); ?>'"
                        style="display: <?php echo ($nego['compteur'] > 1 && $nego['compteur'] % 2 == 0) ? 'block' : 'none'; ?>;"
                    >
                        Oui
                    </button>
                    <button
                        class="change-bg-btn" onclick="non()"
                        style="display: <?php echo ($nego['compteur'] > 1 && $nego['compteur'] % 2 == 0) ? 'block' : 'none'; ?>;"
                    >
                        Non
                    </button>
                </div>

			</div>
			
			<a class="change-bg-btn" href="notifications.php">Retour vers l'Agora</a>
	</div>
</html>