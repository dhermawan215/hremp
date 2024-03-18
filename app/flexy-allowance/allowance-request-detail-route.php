<?php

/**
 * ini ajax untuk allowance detail
 */
include_once '../protected.php';
require_once '../Controller/AllowanceDetailController.php';
require_once '../Controller/AllowanceController.php';
require_once '../Controller/AllowanceDocumentController.php';
header('Content-type: application/json');

use App\Controller\AllowanceDetailController;
use App\Controller\AllowanceController;
use App\Controller\AllowanceDocumentController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {
    $request = $_POST;
    $allowanceDocument = new AllowanceDocumentController;
    $allowanceDetail = new AllowanceDetailController;
    $allowanceController = new AllowanceController;

    if ($request['action'] == 'list-item-attachment') {
        $data = $allowanceDocument->getDataDocuments($request);
        echo json_encode($data);
        exit;
    }

    try {
        /**
         * @route untuk mendapatkan dropdown aktivitas
         */
        if ($request['action'] == 'get-activity') {
            $data = $allowanceDetail->dropdownActivity($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk mendapatkan dropdown aktivitas detail
         */
        if ($request['action'] == 'get-activity-detail') {
            $data = $allowanceDetail->dropdownActivityDetail($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk mendapatkan detail allowance
         */
        if ($request['action'] == 'get-detail-allowance') {
            $data = $allowanceController->getDetailAllowance($request['nomer']);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk mendapatkan detail allowance
         */
        if ($request['action'] == 'list-item-detail-allowance') {
            $data = $allowanceDetail->myDetailAllowance($request);
            echo json_encode($data);
            exit;
        }
        /**
         * @route untuk simpan detail allowance
         */
        if ($request['action'] == 'save' || $request['action'] == 'update') {
            if (isset($request['activity']) && $request['activity'] == '0') {
                http_response_code(403);
                $data[] = 'Field activity is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            if (!isset($request['activity'])) {
                http_response_code(403);
                $data[] = 'Field activity is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }

            if (isset($request['activity_detail']) && $request['activity_detail'] == '0') {
                http_response_code(403);
                $data[] = 'Field detail activity is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            if (!isset($request['activity_detail'])) {
                http_response_code(403);
                $data[] = 'Field detail activity is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }

            if ($request['jumlah_biaya_bon'] == null) {
                http_response_code(403);
                $data[] = 'Field total amount is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            if ($request['jumlah_biaya_klaim'] == null) {
                http_response_code(403);
                $data[] = 'Field claim amount is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            if ($request['tanggal_aktivitas'] == null) {
                http_response_code(403);
                $data[] = 'Field activity date is required';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }
            /**
             * @route untuk simpan data
             */
            if ($request['action'] == 'save') {
                $data = $allowanceDetail->save($request);
                if ($data == true) {
                    $message[] = "Data saved!";
                } else {
                    http_response_code(500);
                    $message[] = "Internal Server Error!, try again";
                }
                echo json_encode(['success' => $data, 'data' => $message]);
                exit;
            }
            /**
             * @route untuk update data
             */
            // if ($request['action'] == 'update') {
            //     $data = $allowanceDetail->update($request);
            //     if ($data == true) {
            //         $message[] = "Data updated!";
            //     } else {
            //         http_response_code(500);
            //         $message[] = "Internal Server Error!, try again";
            //     }
            //     echo json_encode(['success' => $data, 'data' => $message]);
            //     exit;
            // }
        }
        /**
         * @route untuk upload attachment
         */
        if ($request['action'] == 'upload-attachment') {
            $ekstensi_diperbolehkan    = ['pdf', 'png', 'jpg'];
            $nama = $_FILES['document']['name'];
            $x = explode('.', $nama);
            $ekstensi = strtolower(end($x));
            $ukuran    = $_FILES['document']['size'];
            $file_tmp = $_FILES['document']['tmp_name'];

            if (in_array($ekstensi, $ekstensi_diperbolehkan) == false) {

                $data[] = 'File must be in PDF, JPG, and PNG format!';
                echo json_encode(['success' => false, 'data' => $data]);
                exit;
            }

            if ($ukuran > 2044070) {
                $data[] = 'File cannot exceed 2MB!';
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

            $request['file_name'] = $clean_name_file;
            $request['path'] = $clean_name_file;
            $request['temp'] = $file_tmp;
            $data = $allowanceDocument->upload($request);
            if ($data == true) {
                $message[] = "Data saved!";
            } else {
                http_response_code(500);
                $message[] = "Internal Server Error!, try again";
            }
            echo json_encode(['success' => $data, 'data' => $message]);
            exit;
        }
        /**
         * @route untuk tampilin attachment
         */
    } catch (\Throwable $th) {
        var_dump($th);
        exit;
        http_response_code(404);
        $message[] = "Something went wrong!, try again";
        echo json_encode(['success' => $data, 'data' => $message]);
        exit;
    }
}
