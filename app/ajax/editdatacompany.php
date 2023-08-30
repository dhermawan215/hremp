<?php
include_once '../protected.php';
require_once '../Controller/CompanyController.php';

use App\Controller\CompanyController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $company = new CompanyController;
    $data = $company->edit($request['id']);
    // var_dump($data);
    echo json_encode($data);

    exit;
}
