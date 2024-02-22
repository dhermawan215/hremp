<?php
include_once '../protected.php';
require_once '../Controller/AccountLimitController.php';

use App\Controller\AccountLimitController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['users'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Field Nama Karyawan Harus Di isi';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['saldo_awal'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Field Saldo Awal Harus Di isi';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['periode_saldo'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Field Periode Saldo Harus Di isi';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $company = new AccountLimitController;
    $data = $company->save($request);

    if ($data == true) {
        $message[] = "Data saved!";
    } else {
        http_response_code(500);
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $data, 'data' => $message]);

    exit;
}
