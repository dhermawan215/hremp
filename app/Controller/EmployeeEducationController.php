<?php

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

class EmployeeEducationController
{
    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }

    public function store($request)
    {
        $emp_id = $request['emp_id'];
        $pendidikan_terakhir = $request['pendidikan_terakhir'];
        $jurusan = $request['jurusan'];
        $asal_sekolah = $request['asal_sekolah'];

        $sql = "INSERT INTO education(emp_id,pendidikan_terakhir,jurusan,asal_sekolah)
        VALUES($emp_id, '$pendidikan_terakhir', '$jurusan', '$asal_sekolah')";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
