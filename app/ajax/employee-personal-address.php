<?php

include_once '../protected.php';
require_once '../Controller/EmployeePersonalAddressController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['alamat_ktp'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Alamat KTP Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['kelurahan'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Desa/Kelurahan Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['rt'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field RT Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['rw'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field RW Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['kecamatan'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Kecamatan Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['kota'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Kabupaten/Kota Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    if ($request['provinsi'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Provinsi Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['alamat_lengkap'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Alamat Lengkap Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $emp = new EmployeePersonalAddressController();
    $result = $emp->store($request);

    if ($result == true) {
        $message[] = "Data Saved!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $result, 'data' => $message]);
    exit;
}
