<?php
include_once '../protected.php';
require_once '../Controller/CompanyController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    if ($request['company_name'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Nama Company Harus Di isi';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }


    $company = new CompanyController();
    $data = $company->update($request);
    if ($data == true) {
        $message[] = "Data Updated!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $data, 'data' => $message]);

    exit;
}
