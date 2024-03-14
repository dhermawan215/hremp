<?php

include_once '../protected.php';
require_once '../Controller/UserDashboardController.php';
header('Content-type: application/json');

use App\Controller\UserDashboardController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $limit = new UserDashboardController;

    $data = [];
    $dataLimit = $limit->limitEmployee();
    $data['limit'] = $dataLimit->saldo_awal;
    $data['remain'] = $dataLimit->saldo_sisa;
    echo json_encode($data);

    exit;
}
