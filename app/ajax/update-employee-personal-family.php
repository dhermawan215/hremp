<?php

include_once '../protected.php';
require_once '../Controller/EmployeeFamilyController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;

    $emp = new EmployeeFamilyController();
    $result = $emp->update($request);

    if ($result == true) {
        $message[] = "Data has been updated!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $result, 'data' => $message]);
    exit;
}
