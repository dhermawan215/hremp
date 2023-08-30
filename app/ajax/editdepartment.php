<?php
include_once '../protected.php';
require_once '../Controller/DepartmentController.php';

use App\Controller\DepartmentController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $dept = new DepartmentController;
    $data = $dept->edit($request['id']);
    // var_dump($data);
    echo json_encode($data);

    exit;
}
