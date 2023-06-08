<?php

include_once '../protected.php';
require_once '../Controller/EmployeeKontrakController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;

    if (isset($request['awal_kontrak']) && $request['awal_kontrak'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Awal Kontrak Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (isset($request['akhir_kontrak']) && $request['akhir_kontrak'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Akhir Kontrak Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['keterangan'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Keterangan Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    $payroll = new EmployeeKontrakController();
    $result = $payroll->store($request);

    if ($result == true) {
        $message[] = "Data Saved!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $result, 'data' => $message]);
    exit;
}
