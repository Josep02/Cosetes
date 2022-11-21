<?php
declare(strict_types=1);

use App\Media;

session_start();
require_once 'autoload.php';

$dsn = "mysql:host=localhost;dbname=truiter";
try {
    $pdo = new PDO($dsn, "carlos", "carlos");
} catch (PDOException $PDOException) {
    echo $PDOException->getMessage();
}

$isPost = false;
$errors = [];
$attachments = [];
$tmpFiles = [];
$ruta = "uploads";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isPost = true;

    if (empty($_SESSION["data"]["username"])) {
        $errors [] = "Has d'iniciar sessió per a truitejar.";
    } else {
        if (strlen($_POST["tuit"]) > 280 || strlen($_POST["tuit"]) < 1) {
            $errors[] = "El truit no pot estar buit ni superar els 280 caràcters.";
        } else {
            $id = $_SESSION["data"]["id"];
            $tuitFinal = (filter_input(INPUT_POST, "tuit", FILTER_SANITIZE_SPECIAL_CHARS));
            $countfiles = count($_FILES["fitxer"]["name"]);
            $files = $_FILES["fitxer"]["name"];
            $_SESSION["data"]["num"] = $_FILES["fitxer"];

            for ($i = 0; $i < $countfiles; $i++) {
                if ($_FILES["fitxer"]["error"][$i] == UPLOAD_ERR_OK) {
                    if (!is_dir($ruta)) {
                        mkdir($ruta, 0777, true);
                        chmod($ruta, 0777);
                    }
                    $tmpFileName = $_FILES["fitxer"]["tmp_name"][$i];
                    $fileName = basename($_FILES["fitxer"]["name"][$i]);
                    $fileName = uniqid() . ".jpg";

                    $formatPermes = ["jpg", "jpeg"];
                    $validMIMETypes = ["image/jpg", "image/jpeg"];
                    $type = $_FILES["fitxer"]["type"][$i];
                    $extensio = pathinfo($_FILES["fitxer"]["tmp_name"][$i], PATHINFO_EXTENSION);
                    if (!in_array($type, $validMIMETypes)) {
                        $errors [] = "El fitxer ha de ser JPG o JPEG";
                    } else if ($_FILES["fitxer"]["size"][$i] > 10000000) {
                        $errors[] = "El fitxer és massa gran (10 MB màx).";
                    }

                    if (empty($errors)) {
                        $caption = $fileName;
                        $alt_text = $fileName;
                        $url = "$ruta/$fileName";
                        list($width, $height) = getimagesize($tmpFileName);
                        $media = new \App\Photo($caption, $width, $height, $alt_text);
                        $media->setUrl($url);
                        $attachments[] = $media;
                        $tmpFiles[] = $tmpFileName;
                    }
                }
            }
        }
    }
}
if ($isPost == false || !empty($errors)) {
    $_SESSION["errors"] = $errors;
    header('Location: tweet-new.php');
    exit();
} else {
    try {
        $pdo->beginTransaction();
        $consulta1 = $pdo->prepare("SELECT * FROM user");
        $consulta1->execute();
        $resultat1 = $consulta1->fetchAll(PDO::FETCH_ASSOC);

        $insert1 = $pdo->prepare("INSERT INTO tweet (text, author_id, created_at, like_count) values (:text, :author_id, :created_at, :like_count)");
        $text = $tuitFinal;
        $author_id = $id;
        $created_at = date(format: 'Y-m-d H:i:s');
        $like_count = rand(0, count($resultat1));
        $insert1->bindValue("text", $text);
        $insert1->bindValue("author_id", $author_id);
        $insert1->bindValue("created_at", $created_at);
        $insert1->bindValue("like_count", $like_count);
        $insert1->execute();
        $tweet_id = $pdo->lastInsertId();

        foreach ($attachments as $key => $at) {
            $insert2 = $pdo->prepare("INSERT INTO media (alt_text, width, height, url, tweet_id) values (:alt_text, :width, :height, :url, :tweet_id)");
            $url = $at->getUrl();
            $insert2->bindValue("alt_text", $at->getAltText());
            $insert2->bindValue("width", $at->getWidth());
            $insert2->bindValue("height", $at->getHeight());
            $insert2->bindValue("url", $url);
            $insert2->bindValue("tweet_id", $tweet_id);
            $insert2->execute();

            move_uploaded_file($tmpFiles[$key], $url);
            chmod("$ruta/$fileName", 0777);
        }
        $pdo->commit();
    } catch (Exception $exception) {
        $pdo->rollBack();
        echo "Error, " . $exception->getMessage();
    }
    $_SESSION["missatge"] = "El truit s'ha publicat correctament";
    header('Location: index.php');
    exit();
}