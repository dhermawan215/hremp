<?php

/**
 * ini ajax untuk allowance detail
 */
include_once '../protected.php';
require_once '../Controller/AllowanceDetailController.php';
header('Content-type: application/json');

use App\Controller\AllowanceDetailController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    $request = $_POST;
    $allowanceDetail = new AllowanceDetailController;
    try {
        /**
         * @route untuk mendapatkan dropdown aktivitas
         */
        if ($request['action'] == 'get-activity') {
            $data = $allowanceDetail->dropdownActivity($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk mendapatkan dropdown aktivitas detail
         */
        if ($request['action'] == 'get-activity-detail') {
            $data = $allowanceDetail->dropdownActivityDetail($request);
            echo json_encode($data);
            exit;
        }
    } catch (\Throwable $th) {
        http_response_code(404);
        $message[] = "Something went wrong!, try again";
        echo json_encode(['success' => $data, 'data' => $message]);
        exit;
    }
}
