<?php
include_once '../protected.php';
require_once '../Controller/DocumentController.php';

use App\Controller\DocumentController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $dept = new DocumentController;
    $data = $dept->destroy($request['ids']);

    echo json_encode(['success' => $data]);

    exit;
}
