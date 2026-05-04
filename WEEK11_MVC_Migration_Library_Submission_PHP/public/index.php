<?php
require_once __DIR__ . '/../controllers/EntityController.php';

$c = new EntityController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create': $c->create(); break;
    case 'store': $c->store(); break;
    case 'edit': $c->edit(); break;
    case 'update': $c->update(); break;
    case 'delete': $c->delete(); break;
    default: $c->index(); break;
}