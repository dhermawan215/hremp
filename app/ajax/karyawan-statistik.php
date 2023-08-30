<?php

include_once '../protected.php';
require_once '../Controller/DashboardController.php';

use App\Controller\DashboardController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $dept = new DashboardController();
    $data = $dept->statistikTotalKaryawan($request);
    echo json_encode($data);

    exit;
}
