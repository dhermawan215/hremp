<?php

include_once '../protected.php';
require_once '../Controller/AktivitasController.php';
header('Content-type: application/json');

use App\Controller\AktivitasController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;

    $company = new AktivitasController;
    $data = $company->dataAktivitas($request);
    echo json_encode($data);

    exit;
}
