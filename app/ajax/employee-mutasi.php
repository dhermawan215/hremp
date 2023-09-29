<?php

include_once '../protected.php';
require_once '../Controller/EmployeeController.php';

use App\Controller\EmployeeController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['periode_masuk'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Tanggal Masuk Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    if ($request['periode_keluar'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Tanggal Keluar Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['jabatan_baru'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Jabatan Baru Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['jabatan'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Jabatan Terakhir Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (isset($request['comp_baru']) && $request['comp_baru'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Company Baru Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (isset($request['comp_lama']) && $request['comp_lama'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Company Lama Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $emp = new EmployeeController;
    $result = $emp->saveHistory($request);

    if ($result['success'] == true) {
        $message[] = $result['karyawan'];
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $result['success'], 'data' => $message]);
    exit;
}
