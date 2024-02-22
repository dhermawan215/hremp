<?php
include_once '../protected.php';
require_once '../Controller/AllowanceLimitController.php';

use App\Controller\AllowanceLimitController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['nama_limit'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Field Nama Limit Harus Di isi';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['saldo_limit'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Field Saldo Limit Harus Di isi';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $company = new AllowanceLimitController;
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
