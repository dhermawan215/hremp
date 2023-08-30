<?php
include_once '../protected.php';
require_once '../Controller/CompanyController.php';

use App\Controller\CompanyController;

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
    $data = $company->store($request);

    if ($data == true) {
        $message[] = "Data saved!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $data, 'data' => $message]);

    exit;
}
