<?php
require_once '../Controller/LoginController.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    $login = new Login();
    $isLoggedin = $login->login($request);

    $message[] = $isLoggedin['data'];
    echo json_encode(['success' => $isLoggedin['success'], 'data' => $message]);
    exit;
}
