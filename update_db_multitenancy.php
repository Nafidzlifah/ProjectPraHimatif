<?php
require_once 'includes/db.php';

try {
    // 1. Alter participants table
    // Check if column exists to avoid errors on re-run
    $colCheck = $pdo->query("SHOW COLUMNS FROM participants LIKE 'user_id'");
    if ($colCheck->rowCount() == 0) {
        // Assume user_id = 1 for existing records (Migration strategy)
        // If users table has id 1, this works. If not, we might have issues if foreign key checks are strict immediately.
        // Let's first add the column without FK.
        $pdo->exec("ALTER TABLE participants ADD COLUMN user_id INT NOT NULL DEFAULT 1");
        echo "Added user_id to participants.<br>";
        
        // Now add FK
        // Ensure user 1 exists, otherwise create it or update to an existing user?
        // For now, allow it. If user 1 doesn't exist, this might fail if we add CONSTRAINT immediately.
        // Let's safely add index.
        $pdo->exec("ALTER TABLE participants ADD INDEX (user_id)");
    }

    // 2. Alter settings table
    $colCheckSettings = $pdo->query("SHOW COLUMNS FROM settings LIKE 'user_id'");
    if ($colCheckSettings->rowCount() == 0) {
        $pdo->exec("ALTER TABLE settings ADD COLUMN user_id INT NOT NULL DEFAULT 1");
        echo "Added user_id to settings.<br>";
        
        // Remove primary key on 'id' if strictly 1 row logic was used, 
        // but looking at saveConfig, it uses WHERE id=1.
        // We will change logic to use user_id, so let's index user_id.
        $pdo->exec("ALTER TABLE settings ADD INDEX (user_id)");
    }

    echo "Database structure updated for multi-tenancy.<br>";

} catch (PDOException $e) {
    die("Error updating database: " . $e->getMessage());
}
?>
