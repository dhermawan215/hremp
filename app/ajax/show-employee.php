<?php

include_once '../protected.php';
require_once '../Controller/EmployeeController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['_token'])) {
    header('Content-type: application/json');
    $id = $_POST['id'];
    $employee = new EmployeeController();
    $data = $employee->show($id);

    echo json_encode($data);
    exit;
}
