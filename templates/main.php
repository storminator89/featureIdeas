<!DOCTYPE html>
<html>

<head>
    <title>Feature-Ideen-Board</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/img/featureLogo_small.png">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Startseite <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin.php">Admin</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-3"><img src="assets/img/featureLogo_small.png" alt="Logo" style="height: 80px; width: 80x;"> Academy Ideen-Board</h1>
            <div class="form-group search-box">
                <input type="text" id="search" placeholder="Suche...">
                <i class="fas fa-search"></i>
            </div>

        </div>

        <form id="ideaForm" method="post" class="mb-4 needs-validation" novalidate>
            <div class="form-group row">
                <label for="category" class="col-sm-2 col-form-label"><i class="fas fa-tags"></i> Kategorie:</label>
                <div class="col-sm-10">
                    <select name="category" id="category" class="form-control" required>
                        <option value="">Bitte wählen</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Bitte eine Kategorie auswählen.</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="idea" class="col-sm-2 col-form-label"><i class="fas fa-pencil-alt"></i> Idee:</label>
                <div class="col-sm-10">
                    <input type="text" name="idea" id="idea" class="form-control" required>
                    <div class="invalid-feedback">Bitte eine Idee eingeben.</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-2 col-form-label"><i class="fas fa-pencil-alt"></i> Beschreibung:</label>
                <div class="col-sm-10">
                    <textarea name="description" id="description" class="form-control summernote" required></textarea>
                    <div class="invalid-feedback">Bitte eine Beschreibung eingeben.</div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary comment-submit mb-2"><i class="fas fa-plus"></i> Idee einreichen</button>
        </form>

        <?php foreach ($categories as $category) : ?>
            <h2 class="mt-4"><?= htmlspecialchars($category['name']) ?></h2>
            <div class="row">
                <?php foreach ($ideas as $row) : ?>
                    <?php if ($row['category_id'] == $category['id']) : ?>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="fas fa-lightbulb" style="margin-right: 10px;"></i><?= htmlspecialchars($row["idea"]) ?></h5>
                                    <div class="vote-counter">
                                        <span class="badge badge-custom"><?= $row["votes"] ?> Stimmen</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <span class="category-badge category-<?= str_replace(' ', '-', $row["category_name"]) ?>"><?= htmlspecialchars($row["category_name"]) ?></span>
                                    <i class="fas fa-tag"></i>
                                    <p class="card-text"><?= $row["description"] ?></p>
                                    <div class="vote-section">
                                        <?php if (!hasVoted($row["id"])) : ?>
                                            <form method="post">
                                                <button type="submit" name="vote" value="<?= $row["id"] ?>" class="btn btn-success"><i class="fas fa-thumbs-up"></i> Abstimmen</button>
                                            </form>
                                        <?php else : ?>
                                            <button class="btn btn-dark" disabled data-toggle="tooltip" data-placement="top" title="Sie haben bereits abgestimmt"><i class="fas fa-thumbs-up"></i></button>
                                        <?php endif; ?>
                                    </div>
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

    <!-- Dankes-Popup Modal -->
    <div class="modal fade" id="dankesPopup" tabindex="-1" role="dialog" aria-labelledby="dankesPopupLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dankesPopupLabel">Vielen Dank!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Vielen Dank für Ihre Ideeneinreichung. Wir schätzen Ihr Engagement und Ihre Kreativität!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>