<?php

include_once '../protected.php';
require_once '../Controller/AllowanceController.php';

use App\Controller\AllowanceController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_REQUEST;

    $dept = new AllowanceController;
    $dropDown = $dept->departemenDropdown($request);

    echo json_encode($dropDown);
}
