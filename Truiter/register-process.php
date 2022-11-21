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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isPost = true;
    if (empty($_POST['username']) || empty($_POST["name"])) {
        $errors[] = "Heu d'introduir un nom i un usuari";
    } else {
        if (empty($_POST['password']) || empty($_POST['password2'])) {
            $errors[] = "Heu d'introduir una contrasenya";
        } else {
            if (($_POST['password']) !== ($_POST['password2'])) {
                $errors[] = "Les contrasenyes no coincidixen";
            } else {
                $name = trim($_POST['name']);
                $username = trim($_POST['username']);
                $password = trim($_POST['password']);
                if (strlen($name) > 50 || strlen($username) > 15 || strlen($password) > 255) {
                    $errors[] = "S'ha superat la longitud màxima: nom(50), usuari(15), contrasenya(255)";
                }
            }
            try {
                $consulta = $pdo->prepare("SELECT username FROM user WHERE username = ?");
                $consulta->bindValue(1, $username);
                $consulta->execute();
                $results = $consulta->fetch();

            } catch (Exception $exception) {
                $pdo->rollBack();
                echo "Error, " . $exception->getMessage();
            }
            if ($results !== false) {
                $errors[] = "Aquest usuari ja existix.";
            }
        }
    }
}
if ($isPost == false || !empty($errors)) {
    $_SESSION["errors"] = $errors;
    header('Location: register.php');
    exit();
} else {
    try {
        $pdo->beginTransaction();
        $insert1 = $pdo->prepare("INSERT INTO user (name, username, created_at, password, verified) values (:name, :username, :created_at, :password, :verified)");
        $created_at = date(format: 'Y-m-d H:i:s');
        $pwdHash = password_hash($password, PASSWORD_BCRYPT);
        $verified = 0;
        $insert1->bindValue("name", $name);
        $insert1->bindValue("username", $username);
        $insert1->bindValue("created_at", $created_at);
        $insert1->bindValue("password", $pwdHash);
        $insert1->bindValue("verified", $verified);
        $insert1->execute();
        $pdo->commit();
    } catch (Exception $exception) {
        $pdo->rollBack();
        echo "Error, " . $exception->getMessage();
    }
    $_SESSION["missatge"] = "Benvingut " . $name . ", t'has registrat correctament, ja pots iniciar sessió";
    header('Location: index.php');
    exit();
}