<?php
include_once '../protected.php';
require_once '../Controller/AktivitasDetailController.php';

use App\Controller\AktivitasDetailController;

/**
 * @file ajax untuk delete data aktivitas detail
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $company = new AktivitasDetailController;
    $data = $company->delete($request['ids']);

    if ($data == true) {
        echo json_encode(['success' => $data]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => $data]);
    }

    exit;
}
