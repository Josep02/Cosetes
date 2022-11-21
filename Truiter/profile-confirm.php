<?php
declare(strict_types=1);
session_start();

if (empty($_SESSION["errors"]))
    $errors = [];
else {
    $errors = $_SESSION["errors"];
    unset($_SESSION["errors"]);
}

if (empty($_SESSION["data"]["confirm"])) {
    header('Location: profile.php');
    exit();
} else {
    $dsn = "mysql:host=localhost;dbname=truiter";
    try {
        $pdo = new PDO($dsn, "carlos", "carlos");
    } catch (PDOException $PDOException) {
        echo $PDOException->getMessage();
    }

    $consulta1 = $pdo->prepare("SELECT id, name, username, created_at FROM user WHERE id = ?");
    $consulta1->bindValue(1, $_SESSION["data"]["id"]);
    $consulta1->execute();
    $resultat1 = $consulta1->fetchAll(PDO::FETCH_ASSOC);

    $consulta2 = $pdo->prepare("SELECT tweet.id AS tweet_id, tweet.text, tweet.author_id, tweet.created_at, tweet.like_count FROM tweet WHERE tweet.author_id = ?");
    $consulta2->bindValue(1, $_SESSION["data"]["id"]);
    $consulta2->execute();
    $resultat2 = $consulta2->fetchAll(PDO::FETCH_ASSOC);

    $consulta3 = $pdo->prepare("SELECT media.id AS media_id, media.width, media.height, media.alt_text, media.tweet_id, tweet.id AS tweet_id FROM media INNER JOIN tweet ON media.tweet_id = tweet.id");
    $consulta3->execute();
    $resultat3 = $consulta3->fetchAll(PDO::FETCH_ASSOC);
}

require 'views/profile-confirm.view.php';