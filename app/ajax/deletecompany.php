<?php
require_once '../Controller/CompanyController.php';

use App\Controller\CompanyController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST['_token']) {
    header('Content-type: application/json');
    $request = $_REQUEST;

    $company = new CompanyController;
    $data = $company->destroy($request['ids']);
    echo json_encode(['success' => $data]);

    exit;
}
http_response_code(403);
