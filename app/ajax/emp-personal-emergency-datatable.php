<?php

include_once '../protected.php';
require_once '../Controller/EmployeeEmergencyController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $employee = new EmployeeEmergencyController();
    $data = $employee->getDataKontakDarurat($_POST);

    echo json_encode($data);
    exit;
}
