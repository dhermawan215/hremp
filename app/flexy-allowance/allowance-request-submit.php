<?php

/**
 * ini ajax untuk user saat membuat allowance request
 */
include_once '../protected.php';
require_once '../Controller/AllowanceController.php';

use App\Controller\AllowanceController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    if (isset($request['departemen']) && $request['departemen'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Departement is required!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (!isset($request['departemen'])) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Departement is required!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['nama'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Allowance request is required!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $allowanceRequest = new AllowanceController;
    $data = $allowanceRequest->save($request);

    if ($data['success'] == true) {
        $message[] = "Data saved!";
        $content = $data['content'];
    } else {
        http_response_code(500);
        $content = $data['content'];
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $data, 'data' => $message, 'content' => $content]);

    exit;
}
