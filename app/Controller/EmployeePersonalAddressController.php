<?php

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

class EmployeePersonalAddressController
{
    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }

    public function store($request)
    {
        $emp_id = $request['emp_id'];
        $alamat_ktp = $request['alamat_ktp'];
        $kelurahan = $request['kelurahan'];
        $rt = $request['rt'];
        $rw = $request['rw'];
        $kecamatan = $request['kecamatan'];
        $kota = $request['kota'];
        $provinsi = $request['provinsi'];
        $alamat_lengkap = $request['alamat_lengkap'];
        $no_telp = $request['no_telp'];

        $sql = "INSERT INTO emp_personal_address(emp_id,alamat_ktp,rt,rw,kelurahan,kecamatan,kota,provinsi,alamat_lengkap,no_telp)
        VALUES($emp_id, '$alamat_ktp', '$rt', '$rw', '$kelurahan', '$kecamatan', '$kota', '$provinsi', '$alamat_lengkap', '$no_telp' )";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
