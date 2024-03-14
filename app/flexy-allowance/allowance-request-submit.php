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

    if (isset($request['department']) && $request['department'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Departement is required!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (!isset($request['department'])) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Departement is required!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (isset($request['company']) && $request['company'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Company is required!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (!isset($request['company'])) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Company is required!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (isset($request['cost_center']) && $request['cost_center'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Cost center is required!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (!isset($request['cost_center'])) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'cost center is required!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (isset($request['period']) && $request['period'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Period is required!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (!isset($request['period'])) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Period is required!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['transaction_date'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Date is required!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['nama'] == null) {
        // $data['status'] = 0;
        http_response_code(403);
        $data[] = 'Subject allowance request is required!';
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
        $message[] = "Internal Server Error!, please try again";
    }
    echo json_encode(['success' => $data, 'data' => $message, 'content' => $content]);

    exit;
}
