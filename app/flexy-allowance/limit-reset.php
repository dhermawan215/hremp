<?php

include_once '../protected.php';
require_once '../Controller/AccountLimitController.php';
header('Content-type: application/json');

use App\Controller\AccountLimitController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $limit = new AccountLimitController;
    $data = $limit->resetTunjangan($request['formValue']);
    echo json_encode($data);

    exit;
}
