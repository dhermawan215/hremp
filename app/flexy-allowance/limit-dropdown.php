<?php

include_once '../protected.php';
require_once '../Controller/AllowanceLimitController.php';

use App\Controller\AllowanceLimitController;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-type: application/json');
    $request = $_REQUEST;

    $limit = new AllowanceLimitController;
    $dropDown = $limit->getDropdown($request);

    echo json_encode($dropDown);
}
