<?php
include_once '../protected.php';
require_once '../Controller/AccountLimitController.php';

use App\Controller\AccountLimitController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['saldo_awal'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Field Saldo Awal Harus Di isi';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (isset($request['limit']) && $request['limit'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Field Limit Saldo Harus Di isi';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $company = new AccountLimitController;
    $data = $company->update($request);

    if ($data == true) {
        $message[] = "Data updated!";
    } else {
        http_response_code(500);
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $data, 'data' => $message]);

    exit;
}
