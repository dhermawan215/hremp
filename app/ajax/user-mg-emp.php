<?php

include_once '../protected.php';
require_once '../Controller/UserManagementController.php';

use App\Controller\UserManagementController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;
    $user = new UserManagementController;
    $data = $user->updateUserEmployee($request);

    if ($data == true) {
        $message[] = "Data Saved!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }

    echo json_encode(['success' => $data, 'data' => $message]);
    exit;
}
