<?php

/**
 * ini ajax untuk allowance detail
 */
include_once '../protected.php';
require_once '../Controller/AllowanceDetailController.php';
require_once '../Controller/AllowanceController.php';
header('Content-type: application/json');

use App\Controller\AllowanceDetailController;
use App\Controller\AllowanceController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    $request = $_POST;
    $allowanceDetail = new AllowanceDetailController;
    $allowanceController = new AllowanceController;
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
        /**
         * @route untuk mendapatkan detail allowance
         */
        if ($request['action'] == 'get-detail-allowance') {
            $data = $allowanceController->getDetailAllowance($request['nomer']);
            echo json_encode($data);
            exit;
        }

        /**
         * @route untuk simpan detail allowance
         */
        if ($request['action'] == 'save' || $request['action'] == 'update') {
            if (isset($request['activity']) && $request['activity'] == '0') {
                http_response_code(403);
                $data[] = 'Field activity is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            if (!isset($request['activity'])) {
                http_response_code(403);
                $data[] = 'Field activity is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }

            if (isset($request['activity_detail']) && $request['activity_detail'] == '0') {
                http_response_code(403);
                $data[] = 'Field detail activity is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            if (!isset($request['activity_detail'])) {
                http_response_code(403);
                $data[] = 'Field detail activity is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }

            if ($request['jumlah_biaya_bon'] == null) {
                http_response_code(403);
                $data[] = 'Field total amount is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            if ($request['jumlah_biaya_klaim'] == null) {
                http_response_code(403);
                $data[] = 'Field claim amount is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            if ($request['tanggal_aktivitas'] == null) {
                http_response_code(403);
                $data[] = 'Field activity date is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            /**
             * @route untuk simpan data
             */
            if ($request['action'] == 'save') {
                $data = $allowanceDetail->save($request);
                if ($data == true) {
                    $message[] = "Data saved!";
                } else {
                    http_response_code(500);
                    $message[] = "Internal Server Error!, try again";
                }
                echo json_encode(['success' => $data, 'data' => $message]);
                exit;
            }
            /**
             * @route untuk update data
             */
            // if ($request['action'] == 'update') {
            //     $data = $allowanceDetail->update($request);
            //     if ($data == true) {
            //         $message[] = "Data updated!";
            //     } else {
            //         http_response_code(500);
            //         $message[] = "Internal Server Error!, try again";
            //     }
            //     echo json_encode(['success' => $data, 'data' => $message]);
            //     exit;
            // }
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
