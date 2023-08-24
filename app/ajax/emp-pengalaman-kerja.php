<?php

include_once '../protected.php';
include_once '../Controller/EmployeePengalamanController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $dept = new EmployeePengalamanController();
    $data = $dept->getDataPengalaman($request);
    echo json_encode($data);

    exit;
}
