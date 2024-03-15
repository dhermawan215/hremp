<?php

/**
 * ini ajax untuk mendapatkan data cost center, departemen
 * di halaman user add request allowance
 */
include_once '../protected.php';
require_once '../Controller/AllowanceController.php';
header('Content-type: application/json');

use App\Controller\AllowanceController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    $request = $_POST;
    $allowanceController = new AllowanceController;
    try {
        /**
         * @route untuk mendapatkan dropdown cost center
         */
        if ($request['action'] == 'get-cost-center') {
            $data = $allowanceController->dropdownCostCenter($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk mendapatkan dropdown departemen per cost center
         */
        if ($request['action'] == 'get-cost-center-department') {
            $data = $allowanceController->dropdownCostCenterDepartment($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk delete data
         */
        if ($request['action'] == 'delete') {
            $data = $allowanceController->delete($request);
            if ($data['status'] == true) {
                $message[] = $data['message'];
            } else {
                http_response_code(500);
                $message[] = $data['message'];
            }
            echo json_encode(['success' => $data['status'], 'data' => $message]);
            exit;
        }
    } catch (\Throwable $th) {
        var_dump($th);
        exit;
        http_response_code(404);
        $message[] = "Something went wrong!, try again";
        echo json_encode(['success' => $data, 'data' => $message]);
        exit;
    }
}
