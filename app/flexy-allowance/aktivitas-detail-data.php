<?php

include_once '../protected.php';
require_once '../Controller/AktivitasDetailController.php';
header('Content-type: application/json');

use App\Controller\AktivitasDetailController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $company = new AktivitasDetailController;
    $data = $company->dataAktivitas($request);
    echo json_encode($data);

    exit;
}
