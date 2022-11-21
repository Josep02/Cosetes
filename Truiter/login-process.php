<?php
declare(strict_types=1);
session_start();
$dsn = "mysql:host=localhost;dbname=truiter";
try {
    $pdo = new PDO($dsn, "root");
} catch (PDOException $PDOException) {
    echo $PDOException->getMessage();
}
$isPost = false;
$errors = [];
$data["id"] = "";
$data["username"] = "";
$data["name"] = "";
$data["token"] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isPost = true;

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $errors[] = "Heu d'introduir un usuari i una contrasenya";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $pdo->beginTransaction();
        try {
            $consulta = $pdo->prepare("SELECT id, name, username, password FROM user WHERE username = ?");
            $consulta->bindValue(1, $username);
            $consulta->execute();
            $results = $consulta->fetch();
        } catch (Exception $exception) {
            $pdo->rollBack();
            echo "Error, " . $exception->getMessage();
        }
        if ($results == false || ((password_verify($password, $results["password"])) == false)) {
            $errors[] = "Usuari o contrasenya incorrectes.";
        } else {
            $data["username"] = $username;
            $data["name"] = $results["name"];
            $data["id"] = $results["id"];
            $data["token"] = uniqid();
        }
    }
}

if ($isPost == false || !empty($errors)) {
    $_SESSION["errors"] = $errors;
    header('Location: login.php');
    exit();
} else {
    $_SESSION["data"] = $data;
    $_SESSION["missatge"] = "Hola " . $results["name"] . ", has iniciat sessió correctament";
    header('Location: index.php');
    exit();
}