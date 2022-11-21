<?php
declare(strict_types=1);
session_start();
unset($_SESSION["data"]);
$_SESSION["missatge"] = "La sessió s'ha tancat correctament";

header("Location: index.php");
exit();
