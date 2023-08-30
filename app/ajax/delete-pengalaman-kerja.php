<?php

include_once '../protected.php';
include_once '../Controller/EmployeePengalamanController.php';

use App\Controller\EmployeePengalamanController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $dept = new EmployeePengalamanController();
    $result = $dept->delete($request);
    if ($result == true) {
        $message[] = "Data Saved!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $result, 'data' => $message]);
    exit;
}
