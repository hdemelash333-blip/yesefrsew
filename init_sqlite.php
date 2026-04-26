<?php
try {
    $pdo = new PDO("sqlite:database.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Manual table creation for SQLite to avoid syntax issues with MySQL dump
    $pdo->exec("CREATE TABLE IF NOT EXISTS admins (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT, password TEXT, email TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS essays (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, slug TEXT, excerpt TEXT, content TEXT, author TEXT, status TEXT, is_new INTEGER DEFAULT 0, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS interviews (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, slug TEXT, artist_name TEXT, excerpt TEXT, content TEXT, status TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS calls_for_papers (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, slug TEXT, description TEXT, deadline_text TEXT, publication_date_text TEXT, topics TEXT, guidelines TEXT, status TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS news (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, category TEXT, content TEXT, link TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS exhibitions (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, venue TEXT, location TEXT, dates TEXT, description TEXT, link TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS opportunities (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, description TEXT, deadline TEXT, link TEXT, status TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS members (id INTEGER PRIMARY KEY AUTOINCREMENT, type TEXT, name TEXT, email TEXT, discipline TEXT, affiliation TEXT, country TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS subscribers (id INTEGER PRIMARY KEY AUTOINCREMENT, email TEXT, name TEXT, interest TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS paper_submissions (id INTEGER PRIMARY KEY AUTOINCREMENT, call_id INTEGER, name TEXT, email TEXT, affiliation TEXT, paper_title TEXT, abstract TEXT, keywords TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");

    // Insert sample data
    $pdo->exec("INSERT INTO essays (title, slug, excerpt, content, author, status, is_new) VALUES ('Modernism in Ethiopia', 'modernism-in-ethiopia', 'Exploring the roots of modern art...', 'Content...', 'Bekele Mekonnen', 'published', 1)");
    $pdo->exec("INSERT INTO news (title, category, link) VALUES ('1-54 Contemporary African Art Fair', 'Exhibition', 'exhibitions.php')");
    $pdo->exec("INSERT INTO calls_for_papers (title, slug, description, deadline_text, publication_date_text, status) VALUES ('Systemic & Institutional Challenges', 'systemic-challenges', 'Description here...', 'TBA', 'TBA', 'active')");

    echo "SQLite database initialized successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
