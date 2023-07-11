<?php

include_once '../protected.php';
require_once '../Controller/PayrollController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $id = $_POST['id'];
    $employee = new PayrollController();
    $data = $employee->show($id);

    echo json_encode($data);
    exit;
}
