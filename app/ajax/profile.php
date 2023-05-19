<?php

include_once '../protected.php';
require_once '../Controller/ProfileController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    header('Content-type: application/json');
    $request = $_POST;
    if ($request['old_password'] == null) {
        $data[] = 'Field Password Lama Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    if ($request['new_password'] == null) {
        $data[] = 'Field Password Baru Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    if ($request['new_password_confirm'] == null) {
        $data[] = 'Field Konfirmasi Password Harus Diisi!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    $profile = new ProfileController();
    $data = $profile->verifyOldPassword($request);

    if ($data == true) {
        $resultNewPassword = $profile->updatePassword($request);
        echo json_encode($resultNewPassword);
        exit;
    } else {
        $message[] = "Password Lama Anda Tidak Sama!";
        echo json_encode(['success' => $data, 'data' => $message]);
        exit;
    }
}
