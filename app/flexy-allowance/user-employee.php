<?php

include_once '../protected.php';
require_once '../Controller/AccountLimitController.php';

use App\Controller\AccountLimitController;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-type: application/json');
    $request = $_REQUEST;

    $company = new AccountLimitController;
    $dropDown = $company->userEmployee($request);

    echo json_encode($dropDown);
}
