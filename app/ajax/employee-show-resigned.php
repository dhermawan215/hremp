<?php

include_once '../protected.php';
require_once '../Controller/EmployeeController.php';

use App\Controller\EmployeeController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $dept = new EmployeeController();
    $data = $dept->showDataResign($request);
    echo json_encode($data);

    exit;
}
