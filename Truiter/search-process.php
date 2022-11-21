<?php
session_start();
$_SESSION["data"]["confirm"] = "";
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
    if (empty($_POST['search'])) {
        $errors[] = "Introduix alguna paraula per a buscar truits";
    }
}

if ($isPost == false || !empty($errors)) {
    $_SESSION["errors"] = $errors;
    header('Location: index.php');
    exit();
} else {
    try {
        $pdo->beginTransaction();
        $search = filter_var($_POST['search'], FILTER_SANITIZE_SPECIAL_CHARS);
        $consulta1 = $pdo->prepare("SELECT tweet.id AS idtuit, tweet.text, tweet.author_id, tweet.created_at, tweet.like_count, user.id AS iduser,  user.name, user.username FROM tweet INNER JOIN user ON tweet.author_id = user.id WHERE tweet.text LIKE :filter");
        $consulta1->execute(["filter" => "%" . $search . "%"]);
        $resultat1 = $consulta1->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultat1 as $r1) {
            $consulta2 = $pdo->prepare("SELECT * FROM media");
            $consulta2->execute();
            $resultat2 = $consulta2->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (Exception $exception) {
        $pdo->rollBack();
        echo "Error, " . $exception->getMessage();
    }
    require 'views/search-view.php';
    exit();
}