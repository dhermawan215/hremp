<?php

include_once '../protected.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['_token']) {

    $parameter = $_POST['data_karyawan'];
    if (isset($_POST['data_karyawan']) && $parameter == "pribadi") {
        include('pribadi-xls.php');
    }
    if (isset($_POST['data_karyawan']) && $parameter == "alamat") {
        include('pribadi-alamat-xls.php');
    }
    if (isset($_POST['data_karyawan']) && $parameter == "pendidikan") {
        include('pribadi-pendidikan-xls.php');
    }
    if (isset($_POST['data_karyawan']) && $parameter == "keluarga") {
        include('pribadi-keluarga-xls.php');
    }
    if (isset($_POST['data_karyawan']) && $parameter == "emergency") {
        include('pribadi-emergency-xls.php');
    }
    if (isset($_POST['data_karyawan']) && $parameter == "resign-pribadi") {
        include('resign-pribadi-xls.php');
    }
    if (isset($_POST['data_karyawan']) && $parameter == "resign-alamat") {
        include('resign-pribadi-alamat-xls.php');
    }
    if (isset($_POST['data_karyawan']) && $parameter == "resign-pendidikan") {
        include('resign-pribadi-pendidikan-xls.php');
    }
    if (isset($_POST['data_karyawan']) && $parameter == "resign-keluarga") {
        include('resign-pribadi-keluarga-xls.php');
    }
    if (isset($_POST['data_karyawan']) && $parameter == "resign-emergency") {
        include('resign-pribadi-emergency-xls.php');
    }
}
