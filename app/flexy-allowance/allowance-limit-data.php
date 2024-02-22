<?php

include_once '../protected.php';
require_once '../Controller/AllowanceLimitController.php';
header('Content-type: application/json');

use App\Controller\AllowanceLimitController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $company = new AllowanceLimitController;
    $data = $company->dataLimit($request);
    echo json_encode($data);

    exit;
}
