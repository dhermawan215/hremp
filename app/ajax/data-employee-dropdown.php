<?php

include_once '../protected.php';
require_once '../Controller/UserManagementController.php';

use App\Controller\UserManagementController;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-type: application/json');
    $request = $_REQUEST;

    $company = new UserManagementController;
    $dropDown = $company->getEmployeeDropDown($request);

    echo json_encode($dropDown);
}
