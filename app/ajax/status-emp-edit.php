<?php
include_once '../protected.php';
require_once '../Controller/StatusEmployeeController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $dept = new StatusEmployeeController();
    $data = $dept->edit($request['id']);
    // var_dump($data);
    echo json_encode($data);

    exit;
}
