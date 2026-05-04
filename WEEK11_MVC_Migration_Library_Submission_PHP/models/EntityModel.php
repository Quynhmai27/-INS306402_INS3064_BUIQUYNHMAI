<?php
require_once __DIR__ . '/../config/database.php';

class EntityModel {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function getAll() {
        return $this->pdo->query("SELECT * FROM entity")->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM entity WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO entity(name) VALUES(?)");
        return $stmt->execute([$data['name']]);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE entity SET name=? WHERE id=?");
        return $stmt->execute([$data['name'], $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM entity WHERE id=?");
        return $stmt->execute([$id]);
    }
}