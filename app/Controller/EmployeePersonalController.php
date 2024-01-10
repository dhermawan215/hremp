<?php

namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

use App\Database\Databases;
use App\Controller\UriController;

class EmployeePersonalController
{
    private $db;
    public $home;
    public function __construct()
    {
        $this->db = new Databases;
        $this->home = new UriController;
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
        $npwp = $request['npwp'];
        $npwp2 = $request['npwp_pemadanan'];
        $domisili = $request['domisili'];

        $sql = "INSERT INTO emp_personal(emp_id,tempat_lahir,tanggal_lahir,status_pernikahan,golongan_darah,agama,gender,nik,email,no_hp,npwp,npwp_pemadanan,domisili)
        VALUES($emp_id, '$tempat_lahir', '$tanggal_lahir', '$status_pernikahan', '$golongan_darah', '$agama', '$gender', '$nik', '$email', '$no_hp', '$npwp','$npwp2','$domisili')";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }

    public function show($id)
    {
        $sql = "SELECT id_personal,emp_id,id_employee,nama,tanggal_lahir,tempat_lahir,status_pernikahan,
        agama,gender,nik,golongan_darah,email,no_hp,npwp,npwp_pemadanan,domisili
        FROM emp_personal JOIN employee ON emp_personal.emp_id=employee.id_employee WHERE id_employee=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        if ($resultQuery->num_rows == 0) {
            $data['data_index'] = null;
            $data['nama'] = null;
            $data['tanggal_lahir'] = null;
            $data['tempat_lahir'] = null;
            $data['status_pernikahan'] = null;
            $data['agama'] = null;
            $data['gender'] = null;
            $data['nik'] = null;
            $data['golongan_darah'] = null;
            $data['email'] = null;
            $data['no_hp'] = null;
            $data['npwp'] = null;
            $data['npwp_pemadanan'] = null;
            $data['domisili'] = null;

            return $data;
        } else {
            $fetchQuery = $resultQuery->fetch_object();

            $data['data_index'] = $fetchQuery->id_personal;
            $data['nama'] = $fetchQuery->nama;
            $data['tanggal_lahir'] = $fetchQuery->tanggal_lahir;
            $data['tempat_lahir'] = $fetchQuery->tempat_lahir;
            $data['status_pernikahan'] = $fetchQuery->status_pernikahan;
            $data['agama'] = $fetchQuery->agama;
            $data['gender'] = $fetchQuery->gender;
            $data['nik'] = $fetchQuery->nik;
            $data['golongan_darah'] = $fetchQuery->golongan_darah;
            $data['email'] = $fetchQuery->email;
            $data['no_hp'] = $fetchQuery->no_hp;
            $data['npwp'] = $fetchQuery->npwp;
            $data['npwp_pemadanan'] = $fetchQuery->npwp_pemadanan;
            $data['domisili'] = $fetchQuery->domisili;

            return $data;
        }
    }

    public function update($request)
    {
        $id = $request['idData'];
        $emp_id = $request['emp_id'];
        $tempat_lahir = $request['tempat_lahir'];
        $tanggal_lahir = $request['tanggal_lahir'];
        $status_pernikahan = $request['status_pernikahan'];
        $agama = $request['agama'];
        $gender = $request['gender'];
        $nik = $request['nik'];
        $golongan_darah = $request['golongan_darah'];
        $email = $request['email'];
        $no_hp = $request['no_hp'];
        $npwp = $request['npwp'];
        $npwp2 = $request['npwp_pemadanan'];
        $domisili = $request['domisili'];

        $sql = "UPDATE emp_personal SET tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir',
        status_pernikahan='$status_pernikahan', agama='$agama', gender='$gender', nik='$nik',
        golongan_darah='$golongan_darah', email='$email', no_hp='$no_hp',npwp='$npwp',npwp_pemadanan='$npwp2', domisili='$domisili'
        WHERE id_personal=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
