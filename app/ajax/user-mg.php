<?php

include_once '../protected.php';
require_once '../Controller/UserManagementController.php';

use App\Controller\UserManagementController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;
    $user = new UserManagementController;
    $data = $user->dataUser($request);

    echo json_encode($data);
    exit;
}
