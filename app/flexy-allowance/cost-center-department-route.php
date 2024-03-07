<?php

include_once '../protected.php';
require_once '../Controller/CostCenterDepartmentController.php';
header('Content-type: application/json');

use App\Controller\CostCenterDepartmentController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    $request = $_POST;
    $costCenterDepartment = new CostCenterDepartmentController;

    try {
        // validasi untuk simpan dan update
        if ($request['action'] == 'save' || $request['action'] == 'update') {
            if (isset($request['department']) && $request['department'] == null) {
                http_response_code(403);
                $data[] = 'Field department is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            if (!isset($request['department'])) {
                http_response_code(403);
                $data[] = 'Field department is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            /**
             * @route untuk simpan data
             */
            if ($request['action'] == 'save') {
                $data = $costCenterDepartment->store($request);
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
                $data = $costCenterDepartment->update($request);
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
            $data = $costCenterDepartment->costCenterDepartment($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk delete
         */
        if ($request['action'] == 'delete') {
            $data = $costCenterDepartment->delete($request['ids']);
            if ($data == true) {
                echo json_encode(['success' => $data]);
            } else {
                http_response_code(500);
                echo json_encode(['success' => $data]);
            }
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
