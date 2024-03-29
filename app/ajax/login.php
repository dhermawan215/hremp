<?php

// namespace App\Ajax;
require_once '../Controller/LoginController.php';

use App\Controller\Login as LoginController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $response = [];

    $request = $_POST;

    //validasi
    if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
        // $data['status'] = 0;
        $data[] = 'Email Tidak Valid';
        $response[] = $data;
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    if ($request['password'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Password Harus Di isi';
        $response[] = $data;
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $login = new LoginController;

    $isLoggedin = $login->login($request);

    $message[] = $isLoggedin['data'];
    echo json_encode(['success' => $isLoggedin['success'], 'data' => $message]);
    exit;
}

http_response_code(403);
