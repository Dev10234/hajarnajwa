<?php
session_start();
require_once 'connexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (empty($login) || empty($password)) {
        $error = "Les données d’authentification sont obligatoires.";
        header("Location: authentifier.php?error=" . urlencode($error));
        exit();
    }
    $stmt = $pdo->prepare("SELECT * FROM compteadministrateur WHERE login = :login AND password = :password");
    $stmt->execute(['login'=> $login, 'password' => $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['login'] = $login;
        header("Location: espaceprivee.php");
        exit();
    } else {
        $error = "Les données d’authentification sont incorrects.";
        header("Location: authentifier.php?error=" . urlencode($error));
        exit();
    }
}
?>
<form method="post" action="authentifier.php">
    <label>Login: <input type="text" name="login"></label><br>
    <label>Password: <input type="password" name="password"></label><br>
    <input type="submit" value="Se connecter">
</form>
<?php if (isset($_GET['error'])) { echo "<p style='color:red;'>".$_GET['error']."</p>"; } ?>
