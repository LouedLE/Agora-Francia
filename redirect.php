<?php
session_start();
//Si aucun utilisateur connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.html");
    exit;
}
?>