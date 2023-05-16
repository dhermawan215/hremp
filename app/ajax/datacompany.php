<?php
require_once '../Controller/CompanyController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $company = new CompanyController();
    $data = $company->getDataCompany($request);
    echo json_encode($data);

    exit;
}
http_response_code(403);
