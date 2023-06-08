<?php

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

class EmployeeEmergencyController
{
    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }

    public function store($request)
    {
        $emp_id = $request['emp_id'];
        $nama = $request['nama'];
        $alamat = $request['alamat'];
        $no_telp = $request['no_telp'];
        $hubungan = $request['hubungan'];

        $sql = "INSERT INTO emergency(emp_id,nama,alamat,no_telp,hubungan)
        VALUES($emp_id, '$nama', '$alamat', '$no_telp', '$hubungan')";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
