<?php

include_once '../protected.php';
require_once '../Controller/EmployeeKontrakController.php';

use App\Controller\EmployeeKontrakController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $dept = new EmployeeKontrakController();
    $data = $dept->showReminderContract($request);
    echo json_encode($data);

    exit;
}
