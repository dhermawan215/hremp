<?php

include_once '../protected.php';
require_once '../Controller/EmployeePengalamanController.php';

use App\Controller\EmployeePengalamanController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;

    if (isset($request['perusahaan']) && $request['perusahaan'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Perusahaan Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (isset($request['jabatan']) && $request['jabatan'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Jabatan Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (isset($request['periode_masuk']) && $request['periode_masuk'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Periode Masuk Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (isset($request['periode_keluar']) && $request['periode_keluar'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Periode Masuk Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['keterangan'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Keterangan Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    $payroll = new EmployeePengalamanController();
    $result = $payroll->store($request);

    if ($result == true) {
        $message[] = "Data Saved!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $result, 'data' => $message]);
    exit;
}
