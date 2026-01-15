<?php
require_once 'db.php';

// --- Session & Auth ---
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: index.php");
        exit;
    }
}

function login($email, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        return true;
    }
    return false;
}

function register($name, $email, $password) {
    global $pdo;
    
    // Check if email exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        return false; // Email already taken
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $email, $hashed_password]);
}

function logout() {
    session_destroy();
    header("Location: index.php");
    exit;
}

// --- Participants Functions ---

function getUserId() {
    return $_SESSION['user_id'] ?? 0;
}

function getParticipants() {
    global $pdo;
    $user_id = getUserId();
    $stmt = $pdo->prepare("SELECT * FROM participants WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

function getParticipant($id) {
    global $pdo;
    $user_id = getUserId();
    $stmt = $pdo->prepare("SELECT * FROM participants WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    return $stmt->fetch();
}

function addParticipant($name, $email, $affiliation) {
    global $pdo;
    $user_id = getUserId();
    $stmt = $pdo->prepare("INSERT INTO participants (name, email, affiliation, user_id) VALUES (?, ?, ?, ?)");
    $result = $stmt->execute([$name, $email, $affiliation, $user_id]);
    if ($result) {
        syncParticipantsToJson();
    }
    return $result;
}

function deleteParticipant($id) {
    global $pdo;
    $user_id = getUserId();
    $stmt = $pdo->prepare("DELETE FROM participants WHERE id = ? AND user_id = ?");
    $result = $stmt->execute([$id, $user_id]);
    if ($result) {
        syncParticipantsToJson();
    }
    return $result;
}

// --- Config/Settings Functions ---

function getConfig() {
    global $pdo;
    $user_id = getUserId();
    $stmt = $pdo->prepare("SELECT * FROM settings WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch();
    
    // Return default map if DB is empty or field names differ slightly in usage
    if (!$result) {
        return [
            'event' => 'Default Event',
            'date' => date('Y-m-d'),
            'signer' => 'Signer Name',
            'role' => 'Role Name',
            'template' => 'classic'
        ];
    }

    return [
        'event' => $result['event_name'],
        'date' => $result['event_date'],
        'signer' => $result['signer_name'],
        'role' => $result['signer_role'],
        'template' => $result['template']
    ];
}

// --- JSON Sync Helpers ---

function getJsonPath($filename) {
    // Make JSON user-specific to avoid conflicts
    $user_id = getUserId();
    $parts = pathinfo($filename);
    $name = $parts['filename'] . '_' . $user_id . '.' . $parts['extension'];
    
    $dir = __DIR__ . '/../data';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    
    return $dir . '/' . $name;
}

function syncConfigToJson($data) {
    $path = getJsonPath('config.json');
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
}

function syncParticipantsToJson() {
    // Re-fetch all from DB to ensure sync
    $participants = getParticipants();
    $path = getJsonPath('participants.json');
    file_put_contents($path, json_encode($participants, JSON_PRETTY_PRINT));
}

function saveConfig($data) {
    global $pdo;
    $user_id = getUserId();
    
    // Check if row exists for this user
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM settings WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $check = $stmt->fetchColumn();
    
    if ($check == 0) {
        $stmt = $pdo->prepare("INSERT INTO settings (user_id, event_name, event_date, signer_name, signer_role, template) VALUES (?, ?, ?, ?, ?, ?)");
        $args = [
            $user_id,
            $data['event'],
            $data['date'],
            $data['signer'],
            $data['role'],
            $data['template']
        ];
    } else {
        $stmt = $pdo->prepare("UPDATE settings SET event_name = ?, event_date = ?, signer_name = ?, signer_role = ?, template = ? WHERE user_id = ?");
        $args = [
            $data['event'],
            $data['date'],
            $data['signer'],
            $data['role'],
            $data['template'],
            $user_id
        ];
    }
    
    $result = $stmt->execute($args);

    if ($result) {
        syncConfigToJson($data);
    }

    return $result;
}
?>
