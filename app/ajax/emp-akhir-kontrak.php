<?php

include_once '../protected.php';
include_once '../Controller/EmployeeKontrakController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $dept = new EmployeeKontrakController();
    $data = $dept->showReminderContract($request);
    echo json_encode($data);

    exit;
}
