<?php

include_once '../protected.php';
require_once '../Controller/EmployeeController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['nama'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Nama Kontak Darurat Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    if ($request['alamat'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Alamat Kontak Darurat Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['no_telp'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field No HP/Telp Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['hubungan'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Hubungan Kontak Darurat Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $emp = new EmployeeController();
    $result = $emp->employeeEmergency($request);

    if ($result == true) {
        $message[] = "Data Saved!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $result, 'data' => $message]);
    exit;
}
