<?php

include_once '../protected.php';
require_once '../Controller/EmployeePersonalAddressController.php';

use App\Controller\EmployeePersonalAddressController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $id = $_POST['id'];
    $employee = new EmployeePersonalAddressController;
    $data = $employee->show($id);

    echo json_encode($data);
    exit;
}
