<?php

require_once '../Controller/DocumentController.php';

use App\Controller\DocumentController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $company = new DocumentController;
    $data = $company->getDataDocuments($request);
    echo json_encode($data);

    exit;
}
http_response_code(403);
