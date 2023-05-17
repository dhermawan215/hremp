<?php
include_once '../protected.php';
require_once '../Controller/StatusEmployeeController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['status_name'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Status Karyawan Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $dept = new StatusEmployeeController();
    $data = $dept->update($request);

    if ($data == true) {
        $message[] = "Data Updated!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $data, 'data' => $message]);

    exit;
}
