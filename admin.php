<?php
require_once 'functions.php';

// Überprüfen, ob eine Löschaktion angefordert wurde
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    deleteIdea($delete_id);
    header("Location: admin.php");
    exit;
}

// Funktion zum Löschen einer Idee
function deleteIdea($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM ideas WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Alle Ideen abrufen
$ideas = getIdeas();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin-Bereich - Ideen löschen</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Admin-Bereich</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Idee</th>
                    <th>Kategorie</th>
                    <th>Aktion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ideas as $idea): ?>
                <tr>
                    <td><?= htmlspecialchars($idea['idea']) ?></td>
                    <td><?= htmlspecialchars($idea['category_name']) ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="delete_id" value="<?= $idea['id'] ?>">
                            <button type="submit" class="btn btn-danger">Löschen</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
