<?php

include_once '../protected.php';
require_once '../Controller/DocumentController.php';

use App\Controller\DocumentController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_token'])) {
    header('Content-type: application/json');
    $request = $_POST;

    $ekstensi_diperbolehkan    = array('pdf');
    $nama = $_FILES['file_upload']['name'];
    $x = explode('.', $nama);
    $ekstensi = strtolower(end($x));
    $ukuran    = $_FILES['file_upload']['size'];
    $file_tmp = $_FILES['file_upload']['tmp_name'];

    if (in_array($ekstensi, $ekstensi_diperbolehkan) == false) {

        $data[] = 'File harus berekstensi .pdf';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }

    if ($ukuran > 2044070) {
        $data[] = 'File maksimal berukuran 2MB!';
        echo json_encode(['success' => false, 'data' => $data]);
        exit;
    }


    //mendapatkan nama file//
    $file_name_string = pathinfo($nama, PATHINFO_FILENAME);
    //mengkonversi nama file bila ada spasi ke bentuk strip(-)//
    $file_name_str = str_replace(' ', '-', $file_name_string);
    // mengkonversi nama file bila ada karakter 
    $file_name_str = preg_replace('/[^A-Za-z0-9\-\_]/', '', $file_name_str);
    //mengkonversi nama file bila ada karakter strip(-) dan plus(+) menjadi strip(-)
    $file_name_str = preg_replace('/-+/', '-', $file_name_str);
    //mendapatkan nama file yang sudah bersih dari karakter yang tidak diinginkan
    $clean_name_file = date('Ymds') . '-' . $file_name_str . '.' . $ekstensi;

    $docs = new DocumentController;
    $request['file_name'] = $file_name_str;
    $request['path'] = $clean_name_file;
    $request['temp'] = $file_tmp;
    $result = $docs->upload($request);


    if ($result == true) {
        $message[] = "file uploaded!";
    } else {
        $message[] = "Internal Server Error!, try again";
    }
    echo json_encode(['success' => $result, 'data' => $message]);
    exit;
}
