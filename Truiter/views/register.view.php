<!DOCTYPE html>
<html lang="ca">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>
<main class="border-top mt-4 border-4 border-primary container">
    <div class="row">
        <div class="col-2 border d-flex flex-column justify-content-between">
            <?php require "partials/sidebar.php" ?>
        </div>
        <div class="col-7 border p-4">
            <h2>Registre</h2>
            <?php if (!empty($_SESSION["missatge"])): ?>
                <h6><?= $_SESSION["missatge"] ?></h6>
                <?php unset($_SESSION["missatge"]) ?>
            <?php endif; ?>
            <form class="mb-4" method="post" action="register-process.php">
                <label for="nombre" class="form-label"">Nom</label>
                <input id="nombre mb-2" class="form-control" name="name">

                <label for="usuario" class="form-label"">Usuari</label>
                <input id="usuario mb-2" class="form-control" name="username">

                <label for="password" class="form-label">Contrasenya</label>
                <input type="password" id="password" class="form-control mb-2" name="password">

                <label for="password2" class="form-label">Repetix la contrasenya</label>
                <input type="password" id="password2" class="form-control mb-2" name="password2">

                <button class="btn btn-primary">Registra't</button>
            </form>
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $error) : ?>
                    <h6><?= $error ?></h6>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="col-3 border"></div>
    </div>
</main>
</body>
</html>