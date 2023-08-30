<?php

include_once '../protected.php';
require_once '../Controller/DepartmentController.php';

use App\Controller\DepartmentController;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-type: application/json');
    $request = $_REQUEST;

    $dept = new DepartmentController;
    $dropDown = $dept->getDropdown($request);

    echo json_encode($dropDown);
}
