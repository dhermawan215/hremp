<?php

include_once '../protected.php';
require_once '../Controller/DashboardController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $dept = new DashboardController();
    $data = $dept->statistikStatus($request);
    echo json_encode($data);

    exit;
}
