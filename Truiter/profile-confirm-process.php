<?php
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
    if (empty($_SESSION["data"]["confirm"])) {
        $errors[] = "Error 403";
    }
}

if ($isPost == false || !empty($errors)) {
    $_SESSION["errors"] = $errors;
    header('Location: profile.php');
    exit();
} else {
    try {
        $pdo->beginTransaction();

        $consulta1 = $pdo->prepare("SELECT * FROM user WHERE id = ?");
        $consulta1->bindValue(1, $_SESSION["data"]["id"]);
        $consulta1->execute();
        $resultat1 = $consulta1->fetchAll(PDO::FETCH_ASSOC);

        $consulta2 = $pdo->prepare("SELECT * FROM tweet WHERE author_id = ?");
        $consulta2->bindValue(1, $_SESSION["data"]["id"]);
        $consulta2->execute();
        $resultat2 = $consulta2->fetchAll(PDO::FETCH_ASSOC);

        $consulta3 = $pdo->prepare("SELECT * FROM media");
        $consulta3->execute();
        $resultat3 = $consulta3->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultat2 as $r2) {
            foreach ($resultat3 as $r3) {
                if ($r2["id"] == $r3["tweet_id"]) {
                    $delete1 = $pdo->prepare("DELETE FROM media WHERE tweet_id = ?");
                    $delete1->bindValue(1, $r3["tweet_id"]);
                    $delete1->execute();
                    unlink($r3["url"]);
                }
            }
        }

        $delete2 = $pdo->prepare("DELETE FROM tweet WHERE author_id = ?");
        $delete2->bindValue(1, $_SESSION["data"]["id"]);
        $delete2->execute();

        $delete3 = $pdo->prepare("DELETE FROM user WHERE id = ?");
        $delete3->bindValue(1, $_SESSION["data"]["id"]);
        $delete3->execute();

        $pdo->commit();
    } catch (Exception $exception) {
        $pdo->rollBack();
        echo "Error, " . $exception->getMessage();
    }

    $_SESSION["missatge2"] = "S'ha eliminat el compte correctament, fins prompte!";
    header('Location: logout.php');
    exit();
}