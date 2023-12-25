<!DOCTYPE html>
<html>

<head>
    <title>Feature-Ideen-Board</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="icon" type="image/png" href="assets/img/featureLogo_small.png">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><img src="assets/img/featureLogo_small.png" alt="Logo" style="height: 64px; width: 64x;"> Kurs-Ideen-Board</h1>
            <div class="form-group search-box">
                <input type="text" id="search" placeholder="Suche...">
                <label for="search"><i class="fas fa-search"></i></label>
            </div>
        </div>

        <form method="post" class="mb-4 needs-validation" novalidate>
            <form method="post" class="mb-4 needs-validation" novalidate>
                <div class="form-group">
                    <label for="category"><i class="fas fa-tags"></i> Kategorie:</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="">Bitte wählen</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Bitte eine Kategorie auswählen.</div>
                </div>
                <div class="form-group">
                    <label for="idea"><i class="fas fa-pencil-alt"></i> Idee:</label>
                    <input type="text" name="idea" id="idea" class="form-control" required>
                    <div class="invalid-feedback">Bitte eine Idee eingeben.</div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Idee einreichen</button>
            </form>
            <?php foreach ($categories as $category) : ?>
                <h2 class="mt-4"><?= htmlspecialchars($category['name']) ?></h2>
                <div class="row">
                    <?php foreach ($ideas as $row) : ?>
                        <?php if ($row['category_id'] == $category['id']) : ?>
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-lightbulb"></i> <?= htmlspecialchars($row["idea"]) ?></h5>
                                        <span class="category-badge category-<?= str_replace(' ', '-', $row["category_name"]) ?>"><?= htmlspecialchars($row["category_name"]) ?></span>
                                        <p class="card-text"><i class="fas fa-vote-yea"></i> Stimmen: <?= $row["votes"] ?></p>
                                        <?php if (!hasVoted($row["id"])) : ?>
                                            <form method="post">
                                                <button type="submit" name="vote" value="<?= $row["id"] ?>" class="btn btn-success"><i class="fas fa-thumbs-up"></i> Daumen hoch</button>
                                            </form>
                                        <?php else : ?>
                                            <button class="btn btn-success" disabled><i class="fas fa-thumbs-up"></i> Bereits gevotet</button>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-footer">
                                        <form method="post">
                                            <div class="form-group">
                                                <label for="comment"><i class="fas fa-comments"></i> Kommentar:</label>
                                                <textarea name="comment" id="comment" class="form-control" rows="2"></textarea>
                                            </div>
                                            <input type="hidden" name="idea_id" value="<?= $row['id'] ?>">
                                            <button type="submit" class="btn btn-secondary comment-submit"><i class="fas fa-plus"></i> Kommentar absenden</button>
                                        </form>
                                        <?php foreach (getCommentsByIdea($row['id']) as $comment) : ?>
                                            <p><i class="fas fa-comment"></i> <?= htmlspecialchars($comment['comment']) ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
    </div>
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".card").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>

</html>