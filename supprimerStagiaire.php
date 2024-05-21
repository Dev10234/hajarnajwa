<?php

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: authentifier.php");
    exit();
}

include 'connexion.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM stagiaire WHERE id = :id");
$stmt->execute(['id' => $id]);

header("Location: espaceprivee.php");
exit();
?>
