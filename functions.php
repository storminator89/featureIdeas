<?php
require_once 'config.php';

// Funktion zum Abstimmen
function vote($id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE ideas SET votes = votes + 1 WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Funktion zum Hinzufügen einer neuen Idee
function addIdea($idea, $category_id) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO ideas (idea, category_id) VALUES (:idea, :category_id)");
    $stmt->bindParam(':idea', $idea);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->execute();
}

// Funktion zum Abrufen aller Ideen, sortiert nach Stimmen
function getIdeas() {
    global $conn;
    $stmt = $conn->query("SELECT ideas.*, categories.name as category_name FROM ideas LEFT JOIN categories ON ideas.category_id = categories.id ORDER BY ideas.votes DESC, categories.name ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Funktion zum Abrufen aller Kategorien
function getCategories() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM categories");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Funktion zum Hinzufügen eines Kommentars
function addComment($idea_id, $comment) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO comments (idea_id, comment) VALUES (:idea_id, :comment)");
    $stmt->bindParam(':idea_id', $idea_id);
    $stmt->bindParam(':comment', $comment);
    $stmt->execute();
}

// Funktion zum Abrufen aller Kommentare für eine bestimmte Idee
function getCommentsByIdea($idea_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM comments WHERE idea_id = :idea_id");
    $stmt->bindParam(':idea_id', $idea_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Funktion zum Überprüfen, ob der Benutzer bereits für eine bestimmte Idee abgestimmt hat
function hasVoted($id) {
    $votes = isset($_COOKIE["votes"]) ? explode(",", $_COOKIE["votes"]) : [];
    return in_array($id, $votes);
}

function getVoteCount($idea_id) {
    global $db;
    $stmt = $db->prepare("SELECT COUNT(*) AS vote_count FROM votes WHERE idea_id = ?");
    $stmt->execute([$idea_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['vote_count'];
}

?>
