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
         * @route untuk data table/list need check hr
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
        if ($request['action'] == 'list-item-detail-allowance') {
            $data = $HrAllowanceController->detailItemAllowance($request);
            echo json_encode($data);
            exit;
        }
    } catch (\Throwable $th) {
        exit;
        $message[] = "Something went wrong!, try again";
        echo json_encode(['success' => $data, 'data' => $message]);
        exit;
    }
}
