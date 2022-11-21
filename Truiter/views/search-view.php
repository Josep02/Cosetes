<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Truiter: una grollera còpia de Twitter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body>
<main class="border-top mt-4 border-4 border-primary container">
    <div class="row">
        <div class="col-2 border d-flex flex-column justify-content-between">
            <?php require "partials/sidebar.php" ?>
        </div>
        <div class="col-7 border p-4">
            <?php if (!empty($resultat1)): ?>
                <h2>Truits</h2>
                <?php foreach ($resultat1 as $r1) : ?>
                    <p><?= $r1["name"] ?> (@<?= $r1["username"] ?>)</p>
                    <blockquote><?= $r1["text"] ?></blockquote>
                    <?php foreach ($resultat2 as $r2) : ?>
                        <?php if ($r2["tweet_id"] == $r1["idtuit"]): ?>
                            <p>Foto: (<?= $r2["alt_text"] ?>) - [<?= $r2["width"] ?>x<?= $r2["height"] ?>]</p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <p>Likes: <?= $r1["like_count"]; ?></p>
                    <p><?= $r1["created_at"] ?></p>
                    <hr/>
                <?php endforeach; ?>
            <?php else: ?>
                <h5>No s'ha trobat cap truit, tornant a l'index...</h5>
                <?php header("refresh:5; url=index.php"); ?>
            <?php endif; ?>
        </div>
    </div>
</main>
</body>
</html>