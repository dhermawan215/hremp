<?php
require_once '../Controller/LoginController.php';

use App\Controller\Login;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-type: application/json');
    $response = [];

    $request = $_POST;

    //validasi

    if ($request['name'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Name Harus Di isi';
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

    if ($request['password_confirmation'] == null) {
        // $data['status'] = 0;
        $data[] = 'Field Password Confirmation Harus Di isi';
        $response[] = $data;
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
        // $data['status'] = 0;
        $data[] = 'Email Tidak Valid';
        $response[] = $data;
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    if ($request['password'] != $request['password_confirmation']) {
        // $data['status'] = 0;
        $data[] = 'Password tidak sama!';
        $response[] = $data;

        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $register = new Login();

    $unique = $register->uniqueEmail($request['email']);
    //validasi email terdaftar
    // var_dump($unique);
    if ($unique == 1) {
        // $data['status'] = 0;
        $data[] = 'Email telah terdaftar!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $registerData = $register->register($request);

    if ($registerData) {
        // $data['status'] = 1;
        $data[] = 'Registrasi Berhasil';
        $response[] = $data;
        echo json_encode(['success' => true, 'data' => $data]);
    }

    exit;
}

http_response_code(403);
