<?php
include_once '../protected.php';
require_once '../Controller/AllowanceLimitController.php';

use App\Controller\AllowanceLimitController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $company = new AllowanceLimitController;
    $data = $company->delete($request['ids']);

    if ($data == true) {
        echo json_encode(['success' => $data]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => $data]);
    }

    exit;
}
