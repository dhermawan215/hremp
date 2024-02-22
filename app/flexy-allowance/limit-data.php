<?php

include_once '../protected.php';
require_once '../Controller/AccountLimitController.php';
header('Content-type: application/json');

use App\Controller\AccountLimitController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $company = new AccountLimitController;
    $data = $company->dataAcountWallet($request);
    echo json_encode($data);

    exit;
}
