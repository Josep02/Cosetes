<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Truiter: una grollera còpia de Twitter</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>
<main class="mt-4 container">
    <div class="row">
        <div class="position-fixed col-2 d-flex flex-column justify-content-between h-75">
            <?php require "partials/sidebar.php" ?>
        </div>
        <div class="offset-2 col-6 border-start border-end border-1 p-4">
            <?php if (!empty($_SESSION["missatge"])): ?>
                <h6><?= $_SESSION["missatge"] ?></h6>
                <?php unset($_SESSION["missatge"]) ?>
            <?php endif; ?>
            <?php if (!empty($_SESSION["missatge2"])): ?>
                <h6><?= $_SESSION["missatge2"] ?></h6>
                <?php unset($_SESSION["missatge2"]) ?>
            <?php endif; ?>
            <h1>Benvingut a truiter!</h1>
            <p><?= count($resultat1) ?> usuaris, <?= count($resultat2) ?> truits.</p>

            <h2>Usuaris</h2>
            <?php foreach ($resultat1 as $user) : ?>
                <p><?= $user["name"] ?> (@<?= $user["username"] ?>) - Es va unir el: <?= $user["created_at"] ?></p>
            <?php endforeach; ?>

            <?php if (count($resultat3) > 0) : ?>
                <h3>Attachments</h3>
                <ul>
                    <?php foreach ($resultat3 as $attachment) : ?>
                        <li>Foto <?= $attachment["media_id"] ?> (<?= $attachment["alt_text"] ?>) -
                            [<?= $attachment["width"] ?>x<?= $attachment["height"] ?>]
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <h2>Truits</h2>
            <?php foreach ($resultat2 as $tweet) : ?>
                <p><?= $tweet["name"] ?> (@<?= $tweet["username"] ?>) -
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
        </div>
        <div class="col-4">
            <form class="mb-4" method="post" action="search-process.php">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control input-text" placeholder="Busca truits...">
                    <div class="input-group-append">
                        <button class="btn btn-primary"><i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <?php if (!empty($errors)): ?>
                    <?php foreach ($errors as $error) : ?>
                        <h6><?= $error ?></h6>
                    <?php endforeach; ?>
                <?php endif; ?>
            </form>
        </div>
    </div>
</main>
</body>
</html>