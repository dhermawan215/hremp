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
         * @route untuk mendapatkan data edit allowance
         */
        if ($request['action'] == 'edit') {
            $data = $allowanceController->edit($request['nomer']);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk update data allowance
         */
        if ($request['action'] == 'update') {

            if (isset($request['department']) && $request['department'] == '0') {
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
            if (isset($request['company']) && $request['company'] == '0') {
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
            if (isset($request['cost_center']) && $request['cost_center'] == '0') {
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

            $data = $allowanceController->update($request);
            if ($data == true) {
                $message[] = "Data updated!";
            } else {
                http_response_code(500);
                $message[] = "Internal Server Error!, please try again";
            }
            echo json_encode(['success' => $data, 'data' => $message]);

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










        /**
         * @route untuk print
         */
        if ($request['action'] == 'print') {
            $data = $allowanceController->printAllowance($request['nomer']);
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
