<?php

include_once '../protected.php';
require_once '../Controller/EmployeePersonalController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['tempat_lahir'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Tempat Lahir Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['tanggal_lahir'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Tanggal Lahir Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (isset($request['status_pernikahan']) && $request['status_pernikahan'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Status Pernikahan Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (isset($request['golongan_darah']) && $request['golongan_darah'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Status Golongan Darah Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['agama'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Agama Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['gender'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Jenis Kelamin Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['nik'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field NIK Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['email'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Email Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
        // $data['status'] = 0;
        $data[] = 'Field Email Tidak Valid!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['no_hp'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field No HP Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['domisili'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Domisili Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $emp = new EmployeePersonalController();
    $result = $emp->store($request);

    if ($result == true) {
        $message[] = "Data Saved!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $result, 'data' => $message]);
    exit;
}
