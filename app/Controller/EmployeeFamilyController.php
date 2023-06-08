<?php

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

class EmployeeFamilyController
{
    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }

    public function store($request)
    {
        $emp_id = $request['emp_id'];
        $nama_suami_istri = $request['nama_suami_istri'];
        $anak1 = $request['anak1'];
        $anak2 = $request['anak2'];
        $anak3 = $request['anak3'];
        $anak4 = $request['anak4'];

        $sql = "INSERT INTO emp_families(emp_id,nama_suami_istri,anak1,anak2,anak3,anak4)
        VALUES($emp_id, '$nama_suami_istri', '$anak1', '$anak2', '$anak3', '$anak4')";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
