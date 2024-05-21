<?php

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: authentifier.php");
    exit();
}

include 'connexion.php';

$login = $_SESSION['login'];
$stmt = $pdo->prepare("SELECT nom, prenom FROM compteadministrateur WHERE login = :login");
$stmt->execute(['login' => $login]);
$user = $stmt->fetch();
$nom = $user['nom'];
$prenom = $user['prenom'];

$hour = date("H");
$greeting = ($hour < 18) ? "Bonjour" : "Bonsoir";
echo "<h1>$greeting, $prenom $nom</h1>";


$stmt = $pdo->query("SELECT * FROM stagiaire");

echo "<table border='1'>
<tr>
<th>ID</th>
<th>Nom</th>
<th>Prénom</th>
<th>Filière</th>
<th>Email</th>
<th>modifier</th>
<th>supprimer</th>

</tr>";


while ($row = $stmt->fetch()) {
    echo "<tr>
    <td>{$row['id']}</td>
    <td>{$row['nom']}</td>
    <td>{$row['prenom']}</td>
    <td>{$row['filiere']}</td>
    <td>{$row['dateNaiss']}</td>
    <td><a href='ModifierStagiaire.php'>modifier</a></td>
    <td><a href='supprimerStagiaire.php'>supprimer</a></td>

    
    </tr>";
}
echo "</table>";
?>
