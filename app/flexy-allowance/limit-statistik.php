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
    $data['saldo_awal'] = 'Rp ' . number_format($dataLimit->saldo_awal, 0, ',', '.');
    $data['saldo_sisa'] = 'Rp ' . number_format($dataLimit->saldo_sisa, 0, ',', '.');

    echo json_encode($data);

    exit;
}
