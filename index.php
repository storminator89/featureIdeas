<?php
require_once 'functions.php';

// Abstimmung verarbeiten, wenn Formular gesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["idea"]) && !empty($_POST["idea"]) && isset($_POST["category"]) && isset($_POST["description"])) {
        addIdea($_POST["idea"], $_POST["description"], $_POST["category"]);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif (isset($_POST["vote"]) && !empty($_POST["vote"])) {
        // Abstimmung verarbeiten
        $id = $_POST["vote"];
        if (!hasVoted($id)) {
            vote($id);
            $votes = isset($_COOKIE["votes"]) ? $_COOKIE["votes"] . "," . $id : $id;
            setcookie("votes", $votes, time() + (86400 * 30), "/");
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif (isset($_POST["comment"], $_POST["idea_id"]) && !empty($_POST["comment"])) {
        // Kommentar speichern
        addComment($_POST["idea_id"], $_POST["comment"]);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Daten für die Anzeige vorbereiten
$ideas = getIdeas();
$categories = getCategories();
include 'templates/main.php';
