<?php

namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

use App\Database\Databases;
use App\Controller\UriController;

class EmployeeFamilyController
{
    public function __construct()
    {
        $this->db = new Databases;
        $this->home = new UriController;
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

    public function show($id)
    {
        $sql = "SELECT id_family,emp_id,id_employee,nama,nama_suami_istri,anak1,anak2,anak3,anak4
        FROM emp_families RIGHT JOIN employee ON emp_families.emp_id=employee.id_employee WHERE id_employee=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        if ($resultQuery->num_rows == 0) {
            $data['data_index'] = null;
            $data['nama'] = null;
            $data['nama_suami_istri'] = null;
            $data['anak1'] = null;
            $data['anak2'] = null;
            $data['anak3'] = null;
            $data['anak4'] = null;
            return $data;
        } else {
            $fetchQuery = $resultQuery->fetch_object();

            $data['data_index'] = $fetchQuery->id_family;
            $data['nama'] = $fetchQuery->nama;
            $data['nama_suami_istri'] = $fetchQuery->nama_suami_istri;
            $data['anak1'] = $fetchQuery->anak1;
            $data['anak2'] = $fetchQuery->anak2;
            $data['anak3'] = $fetchQuery->anak3;
            $data['anak4'] = $fetchQuery->anak4;
            return $data;
        }
    }

    public function update($request)
    {
        $id = $request['idData'];
        $emp_id  = $request['emp_id'];
        $nama_suami_istri = $request['nama_suami_istri'];
        $anak1 = $request['anak1'];
        $anak2 = $request['anak2'];
        $anak3 = $request['anak3'];
        $anak4 = $request['anak4'];

        $sql = "UPDATE emp_families SET nama_suami_istri='$nama_suami_istri', 
        anak1='$anak1', anak2='$anak2', anak3='$anak3', anak4='$anak4' WHERE id_family=$id";


        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
