<?php
include_once '../protected.php';
require_once '../Controller/DepartmentController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['dept_name'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Nama Departemen Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $dept = new DepartmentController();
    $data = $dept->update($request);

    if ($data == true) {
        $message[] = "Data saved!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $data, 'data' => $message]);

    exit;
}
