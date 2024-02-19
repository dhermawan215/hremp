<?php
include_once '../protected.php';
require_once '../Controller/AktivitasController.php';

use App\Controller\AktivitasController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $company = new AktivitasController;
    $data = $company->delete($request['ids']);

    if ($data == true) {
        echo json_encode(['success' => $data]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => $data]);
    }

    exit;
}
