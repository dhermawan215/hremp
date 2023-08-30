<?php

include_once '../protected.php';
require_once '../Controller/StatusEmployeeController.php';

use App\Controller\StatusEmployeeController;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-type: application/json');
    $request = $_REQUEST;

    $status = new StatusEmployeeController();
    $dropDown = $status->getDropdown($request);

    echo json_encode($dropDown);
}
