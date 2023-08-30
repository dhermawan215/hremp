<?php

include_once '../protected.php';
require_once '../Controller/EmployeeKontrakController.php';

use App\Controller\EmployeeKontrakController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;
    $employee = new EmployeeKontrakController;
    $data = $employee->showTableData($request);

    echo json_encode($data);
    exit;
}
