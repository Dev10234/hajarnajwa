<?php

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: authentifier.php");
    exit();
}

include 'connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $filiere = $_POST['filiere'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("UPDATE stagiaire SET nom = :nom, prenom = :prenom, filiere = :filiere, email = :email WHERE id = :id");
    $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'filiere' => $filiere, 'email' => $email, 'id' => $id]);
    header("Location: espaceprivee.php");
    exit();
} else {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM stagiaire WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();
}
?>

<form method="post">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <label>Nom: <input type="text" name="nom" value="<?php echo $row['nom']; ?>"></label><br>
    <label>Prénom: <input type="text" name="prenom" value="<?php echo $row['prenom']; ?>"></label><br>
    <label>Filière: <input type="text" name="filiere" value="<?php echo $row['filiere']; ?>"></label><br>
    <label>Email: <input type="email" name="email" value="<?php echo $row['email']; ?>"></label><br>
    <input type="submit" value="Modifier">
</form>
