<?php

/**
 * ini adalah file aja untuk semua kebutuhan di hr panel
 */
include_once '../protected.php';
require_once '../Controller/DirectorAllowanceController.php';
header('Content-type: application/json');

use App\Controller\DirectorAllowanceController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    $request = $_POST;
    $HrAllowanceController = new DirectorAllowanceController;
    try {
        /**
         * @route untuk data table/list need check hr
         */
        if ($request['action'] == 'list-need-check') {
            $data = $HrAllowanceController->direcctorNeedCheckList($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk data table/list approve check hr
         */
        if ($request['action'] == 'list-approve') {
            $data = $HrAllowanceController->directorApproved($request);
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
    } catch (\Throwable $th) {
        var_dump($th);
        exit;
        $message[] = "Something went wrong!, try again";
        echo json_encode(['success' => $data, 'data' => $message]);
        exit;
    }
}
