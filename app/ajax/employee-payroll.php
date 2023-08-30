<?php

include_once '../protected.php';
require_once '../Controller/PayrollController.php';

use App\Controller\PayrollController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['account'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field No Rekening Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['payroll_name'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Nama Bank Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    $payroll = new PayrollController();
    $result = $payroll->store($request);

    if ($result == true) {
        $message[] = "Data Saved!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $result, 'data' => $message]);
    exit;
}
