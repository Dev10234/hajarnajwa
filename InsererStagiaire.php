<?php

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: authentifier.php");
    exit();
}

include 'connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $filiere = $_POST['filiere'];
    $email = $_POST['email'];
    $image = $_FILES['image']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $stmt = $pdo->prepare("INSERT INTO stagiaire (nom, prenom, filiere, email, image) VALUES (:nom, :prenom, :filiere, :email, :image)");
        $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'filiere' => $filiere, 'email' => $email, 'image' => $image]);
        header("Location: espaceprivee.php");
        exit();
    }
}

$stmt = $pdo->query("SELECT * FROM filiere");
?>

<form method="post" enctype="multipart/form-data">
    <label>Nom: <input type="text" name="nom"></label><br>
    <label>Prénom: <input type="text" name="prenom"></label><br>
    <label>Filière: 
        <select name="filiere">
            <?php while ($row = $stmt->fetch()) {
                echo "<option value='{$row['id']}'>{$row['intitule']}</option>";
            } ?>
        </select>
    </label><br>
    <label>Email: <input type="email" name="email"></label><br>
    <label>Image: <input type="file" name="image"></label><br>
    <input type="submit" value="Ajouter">
</form>
