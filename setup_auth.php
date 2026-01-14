<?php
require_once 'includes/db.php';

try {
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Users table created successfully.<br>";

    // Insert default admin if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute(['admin@himatif.org']);
    if ($stmt->fetchColumn() == 0) {
        $password = password_hash('admin', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute(['Admin', 'admin@himatif.org', $password]);
        echo "Default admin account created.<br>";
    } else {
        echo "Default admin account already exists.<br>";
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
