<?php
require_once __DIR__ . '/../models/EntityModel.php';

class EntityController {
    private $model;

    public function __construct() {
        $this->model = new EntityModel();
    }

    public function index() {
        $records = $this->model->getAll();
        require __DIR__ . '/../views/entity/index.php';
    }

    public function create() {
        require __DIR__ . '/../views/entity/create.php';
    }

    public function store() {
        $data = [
            'name' => $_POST['name'] ?? ''
        ];

        $this->model->create($data);

        header("Location: index.php?action=index");
        exit;
    }

    public function edit() {
        $id = $_GET['id'];
        $record = $this->model->getById($id);
        require __DIR__ . '/../views/entity/edit.php';
    }

    public function update() {
        $id = $_POST['id'];
        $data = ['name' => $_POST['name']];
        $this->model->update($id, $data);

        header("Location: index.php?action=index");
        exit;
    }

    public function delete() {
        $id = $_GET['id'];
        $this->model->delete($id);

        header("Location: index.php?action=index");
        exit;
    }
}