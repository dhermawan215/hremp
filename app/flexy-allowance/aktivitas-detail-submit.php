<?php
include_once '../protected.php';
require_once '../Controller/AktivitasDetailController.php';

use App\Controller\AktivitasDetailController;

/**
 * @file ajax untuk simpan data aktivitas detail
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['nama_detail'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Field detail name is required';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $company = new AktivitasDetailController;
    $data = $company->store($request);

    if ($data == true) {
        $message[] = "Data saved!";
    } else {
        http_response_code(500);
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $data, 'data' => $message]);

    exit;
}
