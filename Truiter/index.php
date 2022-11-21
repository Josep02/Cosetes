<?php
session_start();
$_SESSION["data"]["confirm"] = "";
$dsn = "mysql:host=localhost;dbname=truiter";

if (empty($_SESSION["errors"]))
    $errors = [];
else {
    $errors = $_SESSION["errors"];
    unset($_SESSION["errors"]);
}

try {
    $pdo = new PDO($dsn, "root");
} catch (PDOException $PDOException) {
    echo $PDOException->getMessage();
}

$consulta1 = $pdo->prepare("SELECT id, name, username, created_at FROM user");
$consulta1->execute();
$resultat1 = $consulta1->fetchAll(PDO::FETCH_ASSOC);

$consulta2 = $pdo->prepare("SELECT tweet.id AS tweet_id, tweet.text, tweet.author_id, tweet.created_at, tweet.like_count, user.name, user.username, user.id AS user_id FROM tweet INNER JOIN user ON tweet.author_id = user.id");
$consulta2->execute();
$resultat2 = $consulta2->fetchAll(PDO::FETCH_ASSOC);

$consulta3 = $pdo->prepare("SELECT media.id AS media_id, media.width, media.height, media.alt_text, media.tweet_id, tweet.id AS tweet_id FROM media INNER JOIN tweet ON media.tweet_id = tweet.id");
$consulta3->execute();
$resultat3 = $consulta3->fetchAll(PDO::FETCH_ASSOC);

require 'views/index.view.php';