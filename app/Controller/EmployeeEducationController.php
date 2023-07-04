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

    public function show($id)
    {
        $sql = "SELECT id_edu,emp_id,id_employee,nama,pendidikan_terakhir,jurusan,asal_sekolah 
        FROM education JOIN employee ON education.emp_id=employee.id_employee WHERE id_employee=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        if ($resultQuery->num_rows == 0) {
            $data['data_index'] = null;
            $data['nama'] = null;
            $data['pendidikan_terakhir'] = null;
            $data['jurusan'] = null;
            $data['asal_sekolah'] = null;
            return $data;
        } else {
            $fetchQuery = $resultQuery->fetch_object();

            $data['data_index'] = $fetchQuery->id_edu;
            $data['nama'] = $fetchQuery->nama;
            $data['pendidikan_terakhir'] = $fetchQuery->pendidikan_terakhir;
            $data['jurusan'] = $fetchQuery->jurusan;
            $data['asal_sekolah'] = $fetchQuery->asal_sekolah;
            return $data;
        }
    }

    public function update($request)
    {
        $id = $request['idData'];
        $emp_id = $request['emp_id'];
        $pendidikan_terakhir = $request['pendidikan_terakhir'];
        $jurusan = $request['jurusan'];
        $asal_sekolah = $request['asal_sekolah'];

        $sql = "UPDATE education SET pendidikan_terakhir='$pendidikan_terakhir',
        jurusan='$jurusan', asal_sekolah='$asal_sekolah' WHERE id_edu=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
