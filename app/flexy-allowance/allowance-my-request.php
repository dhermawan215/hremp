<?php

/**
 * ini ajax untuk data tabel user di halaman
 * view my allowance request
 */
include_once '../protected.php';
require_once '../Controller/AllowanceController.php';
header('Content-type: application/json');

use App\Controller\AllowanceController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $company = new AllowanceController;
    $data = $company->myAllowanceRequest($request);
    echo json_encode($data);

    exit;
}
