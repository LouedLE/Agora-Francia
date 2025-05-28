<?php
$database = "agora";

$db_handle = mysqli_connect('localhost', 'root', '', $database);

if (!$db_handle) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM articles WHERE ID = ?";
$stmt = $db_handle->prepare($sql);
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $article = $result->fetch_assoc();
} else {
    die("Erreur lors de la récupération des articles : " . $db_handle->error);
}

$stmt->close();
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
    <title>Agora - Achat Immédiat</title>
    <link rel="icon" href="images/logo.png" type="image/png">
</head>
<body>
    <div class="header">
        <img src="images/logo.png" alt="logo" class="logo">
        <h1>Agora Francia</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="parcourir.php">Tout parcourir</a></li>
                <li><a href="notifications.html">Notifications</a></li>
                <li><a href="panier.html">Panier</a></li>
                <li><a href="compte.html">Votre compte</a></li>
            </ul>
        </nav>
    </div>

    <br>

    <div class="article-details">
        <p>Prix à payer : <strong><?php 
        if (isset($article['prix']))
        {echo htmlspecialchars($article['prix']);}
         ?> €</strong></p>
    </div>

    <form method="post" action="achat_immediat.php">
        <h3>Adresse de Livraison</h3>
        <table>
            <tr>
                <td>Nom et Prénom</td>
                <td><input type="text" name="nom" required></td>
            </tr>
            <tr>
                <td>Adresse Ligne 1</td>
                <td><input type="text" name="adresse1" required></td>
            </tr>
            <tr>
                <td>Ville</td>
                <td><input type="text" name="ville" required></td>
            </tr>
            <tr>
                <td>Code Postal</td>
                <td><input type="text" name="code_postal" required></td>
            </tr>
            <tr>
                <td>Pays</td>
                <td><input type="text" name="pays" required></td>
            </tr>
            <tr>
                <td>Numéro de téléphone</td>
                <td><input type="text" name="telephone" required></td>
            </tr>
        </table>

        <h3>Informations de Paiement</h3>
        <table>
            <tr>
                <td>Type de carte</td>
                <td>
                    <select name="type_carte" required>
                        <option value="mastercard">Mastercard</option>
                        <option value="visa">Visa</option>
                        <option value="american express">American Express</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Numéro de carte</td>
                <td><input type="text" name="numero_carte" required></td>
            </tr>
            <tr>
                <td>Date d'expiration</td>
                <td><input type="date" name="date_expiration" required></td>
            </tr>
            <tr>
                <td>Cryptogramme (code de sécurité)</td>
                <td><input type="text" name="cryptogramme" required></td>
            </tr>
        </table>

        <input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
        <button type="submit" name="payer">Payer</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'];
        $adresse1 = $_POST['adresse1'];
        $ville = $_POST['ville'];
        $code_postal = $_POST['code_postal'];
        $pays = $_POST['pays'];
        $telephone = $_POST['telephone'];
        $type_carte = $_POST['type_carte'];
        $numero_carte = $_POST['numero_carte'];
        $date_expiration = $_POST['date_expiration'];
        $cryptogramme = $_POST['cryptogramme'];
        $article_id = $_POST['article_id'];

        $stmt = $db_handle->prepare("INSERT INTO commandes (nom, adresse1, ville, code_postal, pays, telephone, type_carte, numero_carte, date_expiration, cryptogramme, article_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssi", $nom, $adresse1, $ville, $code_postal, $pays, $telephone, $type_carte, $numero_carte, $date_expiration, $cryptogramme, $article_id);

        if ($stmt->execute()) {
            $stmt_delete = $db_handle->prepare("DELETE FROM articles WHERE ID = ?");
            $stmt_delete->bind_param("i", $article_id);
            if ($stmt_delete->execute()) {
                echo "<p>Commande passée avec succès. L'article a été supprimé de la base de données.</p>";
                exit;
            } else {
                echo "<p>Erreur lors de la suppression de l'article : " . $stmt_delete->error . "</p>";
            }
            $stmt_delete->close();
        } else {
            echo "<p>Erreur lors de l'enregistrement de la commande : " . $stmt->error . "</p>";
        }

        $stmt->close();
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