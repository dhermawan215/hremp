<?php

include_once '../protected.php';
require_once '../Controller/EmployeeEducationController.php';

use App\Controller\EmployeeEducationController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;

    if (isset($request['pendidikan_terakhir']) && $request['pendidikan_terakhir'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Pendidikan Terakhir Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['jurusan'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Jurusan Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['asal_sekolah'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Asal Sekolah Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }


    $emp = new EmployeeEducationController();
    $result = $emp->update($request);

    if ($result == true) {
        $message[] = "Data Updated!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $result, 'data' => $message]);
    exit;
}
