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
    unset($_SESSION["data"]);
    $_SESSION["missatge"] = "La sessió s'ha tancat";
    header('Location: register.php');
    exit();
}
require 'views/register.view.php';