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
    if ($request['status_emp'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Status Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }
    if ($request['comp_id'] == null) {
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
    if ($request['dept_id'] == null) {
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

    if (!isset($request['tgl_kartap'])) {
        $request['tgl_kartap'] = null;
    }

    $emp = new EmployeeController();
    $result = $emp->saveEmployee($request);
    var_dump($result);
    exit;
}
