<?php

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

class EmployeePersonalController
{
    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }

    public function store($request)
    {
        $emp_id = $request['emp_id'];
        $tempat_lahir = $request['tempat_lahir'];
        $tanggal_lahir = $request['tanggal_lahir'];
        $status_pernikahan = $request['status_pernikahan'];
        $golongan_darah = $request['golongan_darah'];
        $agama = $request['agama'];
        $gender = $request['gender'];
        $nik = $request['nik'];
        $email = $request['email'];
        $no_hp = $request['no_hp'];
        $domisili = $request['domisili'];

        $sql = "INSERT INTO emp_personal(emp_id,tempat_lahir,tanggal_lahir,status_pernikahan,golongan_darah,agama,gender,nik,email,no_hp,domisili)
        VALUES($emp_id, '$tempat_lahir', '$tanggal_lahir', '$status_pernikahan', '$golongan_darah', '$agama', '$gender', '$nik', '$email', '$no_hp', '$domisili')";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
