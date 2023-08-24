<?php

include_once '../protected.php';
require_once '../Controller/EmployeeController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $id = $_POST['index'];
    $employee = new EmployeeController();
    $data = $employee->employeeDetail($id);

    echo json_encode($data);
    exit;
}
