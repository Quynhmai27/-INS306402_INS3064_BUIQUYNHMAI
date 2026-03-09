<?php
session_start();

define('DATA_FILE', __DIR__ . '/data/users.json');
define('UPLOAD_DIR', __DIR__ . '/uploads/');

if (!file_exists(DATA_FILE)) {
    file_put_contents(DATA_FILE, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

function loadUsers() {
    $data = file_get_contents(DATA_FILE);
    $users = json_decode($data, true);
    return is_array($users) ? $users : [];
}

function saveUsers($users) {
    file_put_contents(DATA_FILE, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function findUserByEmail($email) {
    $users = loadUsers();
    foreach ($users as $user) {
        if (strtolower($user['email']) === strtolower($email)) {
            return $user;
        }
    }
    return null;
}

function findUserByUsername($username) {
    $users = loadUsers();
    foreach ($users as $user) {
        if (strtolower($user['username']) === strtolower($username)) {
            return $user;
        }
    }
    return null;
}

function findUserById($id) {
    $users = loadUsers();
    foreach ($users as $user) {
        if ($user['id'] === $id) {
            return $user;
        }
    }
    return null;
}

function updateUser($updatedUser) {
    $users = loadUsers();
    foreach ($users as $index => $user) {
        if ($user['id'] === $updatedUser['id']) {
            $users[$index] = $updatedUser;
            saveUsers($users);
            return true;
        }
    }
    return false;
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirect('login.php');
    }
}

function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function getCurrentUser() {
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    return findUserById($_SESSION['user_id']);
}

function daysAsMember($createdAt) {
    $created = new DateTime($createdAt);
    $now = new DateTime();
    return $created->diff($now)->days;
}

function bioLength($text) {
    return mb_strlen($text ?? '', 'UTF-8');
}
?>