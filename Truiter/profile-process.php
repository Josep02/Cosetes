<?php
declare(strict_types=1);
session_start();

$dsn = "mysql:host=localhost;dbname=truiter";
try {
    $pdo = new PDO($dsn, "carlos", "carlos");
} catch (PDOException $PDOException) {
    echo $PDOException->getMessage();
}
$isPost = false;
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isPost = true;
    if (empty($_POST['username']) && empty($_POST["name"])) {
        $errors[] = "Heu d'almenys un camp que s'ha de modificar";
    } else {
        $name = trim($_POST['name']);
        $username = trim($_POST['username']);
        if (strlen($name) > 50 || strlen($username) > 15) {
            $errors[] = "S'ha superat la longitud màxima de caràcters: nom(50), usuari(15)";
        }
    }
}

if ($isPost == false || !empty($errors)) {
    $_SESSION["errors"] = $errors;
    header('Location: profile.php');
    exit();
} else {
    if (empty($_POST["name"])) {
        $username = trim($_POST['username']);
        try {
            $pdo->beginTransaction();
            $consulta1 = $pdo->prepare("SELECT id, name, username FROM user WHERE username = ?");
            $consulta1->bindValue(1, trim($_SESSION["data"]["username"]));
            $consulta1->execute();
            $result1 = $consulta1->fetch();

            $insert1 = $pdo->prepare("UPDATE user SET username = :username WHERE id = :id ");
            $insert1->bindValue("username", $username);
            $insert1->bindValue("id", $result1["id"]);
            $insert1->execute();
            $pdo->commit();

            unset($_SESSION["data"]);
            $_SESSION["data"]["username"] = $username;
            $_SESSION["data"]["name"] = $result1["name"];
            $_SESSION["data"]["id"] = $result1["id"];
            $_SESSION["data"]["token"] = uniqid();

        } catch (Exception $exception) {
            $pdo->rollBack();
            echo "Error, " . $exception->getMessage();
        }
    } else if (empty($_POST["username"])) {
        $name = trim($_POST['name']);
        try {
            $pdo->beginTransaction();
            $consulta2 = $pdo->prepare("SELECT id, name, username FROM user WHERE name = ?");
            $consulta2->bindValue(1, trim($_SESSION["data"]["name"]));
            $consulta2->execute();
            $result2 = $consulta2->fetch();

            $insert2 = $pdo->prepare("UPDATE user SET name = :name WHERE id = :id ");
            $insert2->bindValue("name", $name);
            $insert2->bindValue("id", $result2["id"]);
            $insert2->execute();
            $pdo->commit();

            unset($_SESSION["data"]);
            $_SESSION["data"]["username"] = $result2["username"];
            $_SESSION["data"]["name"] = $name;
            $_SESSION["data"]["id"] = $result2["id"];
            $_SESSION["data"]["token"] = uniqid();

        } catch (Exception $exception) {
            $pdo->rollBack();
            echo "Error, " . $exception->getMessage();
        }
    } else {
        $name = trim($_POST['name']);
        $username = trim($_POST['username']);
        try {
            $pdo->beginTransaction();
            $consulta3 = $pdo->prepare("SELECT id, name, username FROM user WHERE id = ?");
            $consulta3->bindValue(1, $_SESSION["data"]["id"]);
            $consulta3->execute();
            $result3 = $consulta3->fetch();

            $insert3 = $pdo->prepare("UPDATE user SET name = :name, username = :username WHERE id = :id ");
            $insert3->bindValue("name", $name);
            $insert3->bindValue("username", $username);
            $insert3->bindValue("id", $result3["id"]);
            $insert3->execute();
            $pdo->commit();

            unset($_SESSION["data"]);
            $_SESSION["data"]["username"] = $username;
            $_SESSION["data"]["name"] = $name;
            $_SESSION["data"]["id"] = $result3["id"];
            $_SESSION["data"]["token"] = uniqid();

        } catch (Exception $exception) {
            $pdo->rollBack();
            echo "Error, " . $exception->getMessage();
        }
    }

    $_SESSION["missatge"] = "S'han modificat les dades correctament";
    header('Location: index.php');
    exit();
}