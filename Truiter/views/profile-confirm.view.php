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
            <h2>Eliminar compte de truiter</h2>
            <br>
            <h5>Resum del teu compte</h5>
            <br>
            <h5>Usuari</h5>
            <?php foreach ($resultat1 as $user) : ?>
                <p><?= $user["name"] ?> (@<?= $user["username"] ?>) - Et vas unir el: <?= $user["created_at"] ?></p>
            <?php endforeach; ?>

            <h5>Truits</h5>
            <?php foreach ($resultat2 as $tweet) : ?>
                <p><?= $user["name"] ?> (@<?= $user["username"] ?>) -
                    <?= $tweet["created_at"] ?></p>
                <blockquote><?= $tweet["text"] ?></blockquote>
                <?php foreach ($resultat3 as $foto) : ?>
                    <?php if ($foto["tweet_id"] == $tweet["tweet_id"]): ?>
                        <p>Foto: (<?= $foto["alt_text"] ?>) - [<?= $foto["width"] ?>x<?= $foto["height"] ?>]</p>
                    <?php endif; ?>
                <?php endforeach; ?>
                <p>Likes: <?= $tweet["like_count"]; ?></p>
                <hr/>
            <?php endforeach; ?>
            <h5>Segur que vols eliminar el teu compte?</h5>
            <br>
            <form class="mb-4" method="post" action="profile-confirm-process.php">
                <button class="btn btn-danger">Elimina el meu compte</button>
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