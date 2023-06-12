<?php

include_once '../protected.php';
require_once '../Controller/EmployeeController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['nip'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field NIP Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['nama'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Nama Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (!isset($request['status_emp'])) {
        // $data['status'] = 0;
        $data[] = 'Field Status Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (!isset($request['comp_id'])) {
        // $data['status'] = 0;
        $data[] = 'Field Company Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['lokasi'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Lokasi Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if (!isset($request['dept_id'])) {
        // $data['status'] = 0;
        $data[] = 'Field Departemen Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['tgl_masuk'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Tanggal Masuk Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['email_kantor'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Email Kerja Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    if (!filter_var($request['email_kantor'], FILTER_VALIDATE_EMAIL)) {
        // $data['status'] = 0;
        $data[] = 'Field Email Kerja Tidak Valid!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['pangkat'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Pangkat Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['jabatan'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Jabatan Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['bpjstk'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field BPJS Tenaga Kerja Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['bpjskes'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field BPJS Kesehatan Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    if (isset($request['tgl_kartap'])) {
        if ($request['tgl_kartap'] == null) {
            $data[] = 'Field Tanggal Kartap Harus Diisi!';
            echo json_encode(['success' => false, 'data' => $data]);
            exit;
        }
    }

    $emp = new EmployeeController();
    // $validateNip = $emp->validateNip($request['nip']);

    // if ($validateNip == 1) {
    //     $data[] = 'NIP Sudah Terdaftar!';
    //     echo json_encode(['success' => false, 'data' => $data]);
    //     exit;
    // }

    $result = $emp->update($request);

    if ($result == true) {
        $message[] = "Data updated!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $result, 'data' => $message]);
    exit;
}
