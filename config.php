<?php
// Verbindung zur SQLite-Datenbank herstellen
try {
    $conn = new PDO("sqlite:ideas.db");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tabellen erstellen, falls sie nicht existieren
    $conn->exec("CREATE TABLE IF NOT EXISTS categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL
    )");

    $conn->exec("CREATE TABLE IF NOT EXISTS ideas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        category_id INTEGER,
        idea TEXT NOT NULL,
        votes INTEGER DEFAULT 0,
        FOREIGN KEY (category_id) REFERENCES categories(id)
    )");

    $conn->exec("CREATE TABLE IF NOT EXISTS comments (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        idea_id INTEGER,
        comment TEXT NOT NULL,
        FOREIGN KEY (idea_id) REFERENCES ideas(id)
    )");

} catch(PDOException $e) {
    die("Verbindung fehlgeschlagen: " . $e->getMessage());
}

// Kategorien hinzufügen, falls sie nicht existieren
$categories = [
    'Prozessdesign Grundlagen',
    'Prozessdesign Fortgeschritten',
    'Installation',
    'Administration',
    'Vertriebsschulung',
    'Neuerungen',
    'Rezertifizierung',
    'Module'
];

$stmt = $conn->prepare("INSERT INTO categories (name) SELECT :name WHERE NOT EXISTS (SELECT 1 FROM categories WHERE name = :name)");

foreach ($categories as $category) {
    $stmt->bindParam(':name', $category);
    $stmt->execute();
}

?>
