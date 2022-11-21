<?php
declare(strict_types=1);
session_start();
$_SESSION["data"]["confirm"] = "";

if (empty($_SESSION["errors"]))
    $errors = [];
else {
    $errors = $_SESSION["errors"];
    unset($_SESSION["errors"]);
}

if (empty($_SESSION["data"]["username"]) && empty($_SESSION["data"]["token"])) {
    header('Location: login.php');
    exit();
}
require 'views/tweet-new.view.php';