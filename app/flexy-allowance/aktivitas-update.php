<?php
include_once '../protected.php';
require_once '../Controller/AktivitasController.php';

use App\Controller\AktivitasController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['nama'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Field Nama Aktivitas Harus Di isi';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $company = new AktivitasController;
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
