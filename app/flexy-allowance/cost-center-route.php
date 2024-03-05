<?php

include_once '../protected.php';
require_once '../Controller/CostCenterController.php';
header('Content-type: application/json');

use App\Controller\CostCenterController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    $request = $_POST;
    $costcenterController = new CostCenterController;

    try {
        // validasi untuk simpan dan update
        if ($request['action'] == 'save' || $request['action'] == 'update') {
            if (isset($request['company']) && $request['company'] == null) {
                http_response_code(403);
                $data[] = 'Field company is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            if (!isset($request['company'])) {
                http_response_code(403);
                $data[] = 'Field company is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            if ($request['cost_center_name'] == null) {
                http_response_code(403);
                $data[] = 'Field cost center name is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            /**
             * @route untuk simpan data
             */
            if ($request['action'] == 'save') {
                $data = $costcenterController->store($request);
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
            if ($request['action'] == 'update') {
                $data = $costcenterController->update($request);
                if ($data == true) {
                    $message[] = "Data updated!";
                } else {
                    http_response_code(500);
                    $message[] = "Internal Server Error!, try again";
                }
                echo json_encode(['success' => $data, 'data' => $message]);
                exit;
            }
        }
        /**
         * @route untuk data table
         */
        if ($request['action'] == 'get-data') {
            $data = $costcenterController->dataCostCenter($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk edit data
         */
        if ($request['action'] == 'edit') {
            $data = $costcenterController->edit($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk delete
         */
        if ($request['action'] == 'delete') {
            $data = $costcenterController->delete($request['ids']);
            if ($data == true) {
                echo json_encode(['success' => $data]);
            } else {
                http_response_code(500);
                echo json_encode(['success' => $data]);
            }
            exit;
        }
    } catch (\Throwable $th) {
        http_response_code(404);
        $message[] = "Something went wrong!, try again";
        echo json_encode(['success' => $data, 'data' => $message]);
        exit;
    }
}
