<?php

/**
 * ini adalah file aja untuk semua kebutuhan di hr panel
 */
include_once '../protected.php';
require_once '../Controller/HrAllowanceController.php';
header('Content-type: application/json');

use App\Controller\HrAllowanceController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    $request = $_POST;
    $HrAllowanceController = new HrAllowanceController;
    try {
        /**
         * @route untuk data table/list need check hr
         */
        if ($request['action'] == 'list-need-check') {
            $data = $HrAllowanceController->hrNeedCheckList($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk data table/list approve check hr
         */
        if ($request['action'] == 'list-approve') {
            $data = $HrAllowanceController->hrApproved($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk data table/list detail allowance
         */
        if ($request['action'] == 'list-item-detail-allowance') {
            $data = $HrAllowanceController->detailItemAllowance($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk data table/list dokumen allowance
         */
        if ($request['action'] == 'list-attachment-allowance') {
            $data = $HrAllowanceController->documentAllowance($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk data detail allowance
         */
        if ($request['action'] == 'get-detail-allowance') {
            $data = $HrAllowanceController->getDetailAllowance($request['nomer']);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk aksi approve by aplikasi
         */
        if ($request['action'] == 'approve') {
            $data = $HrAllowanceController->approve($request);
            if ($data['status'] == true) {
                $message[] = $data['message'];
            } else {
                http_response_code(500);
                $message[] = $data['message'];
            }
            echo json_encode(['success' => $data, 'data' => $message]);
            exit;
        }
        /**
         * @route untuk aksi revisi by aplikasi
         */
        if ($request['action'] == 'revision') {
            $data = $HrAllowanceController->revision($request);
            if ($data['status'] == true) {
                $message[] = $data['message'];
            } else {
                http_response_code(500);
                $message[] = $data['message'];
            }
            echo json_encode(['success' => $data, 'data' => $message]);
            exit;
        }
        /**
         * @route untuk aksi reject by aplikasi
         */
        if ($request['action'] == 'rejection') {
            $data = $HrAllowanceController->rejected($request);
            if ($data['status'] == true) {
                $message[] = $data['message'];
            } else {
                http_response_code(500);
                $message[] = $data['message'];
            }
            echo json_encode(['success' => $data, 'data' => $message]);
            exit;
        }
    } catch (\Throwable $th) {
        var_dump($th);
        exit;
        $message[] = "Something went wrong!, try again";
        echo json_encode(['success' => $data, 'data' => $message]);
        exit;
    }
}
