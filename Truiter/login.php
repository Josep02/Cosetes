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

if (!empty($_SESSION["data"]["username"]) && !empty($_SESSION["data"]["token"])) {
    header('Location: index.php');
    exit();
}

require 'views/login.view.php';
