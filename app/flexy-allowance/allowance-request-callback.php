<?php

include_once '../protected.php';
require_once '../Controller/AllowanceController.php';

use App\Controller\AllowanceController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_REQUEST;

    $limit = new AllowanceController;
    $allowanceNumber = $limit::getNomerAllowance();

    echo json_encode($allowanceNumber);
}
