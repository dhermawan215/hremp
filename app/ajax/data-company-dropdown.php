<?php

include_once '../protected.php';
require_once '../Controller/CompanyController.php';

use App\Controller\CompanyController;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-type: application/json');
    $request = $_REQUEST;

    $company = new CompanyController;
    $dropDown = $company->getDropdown($request);

    echo json_encode($dropDown);
}
