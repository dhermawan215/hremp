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

    public function show($id)
    {
        $sql = "SELECT id_emergency, emergency.nama AS nama_emergency, alamat, no_telp, hubungan, emp_id, id_employee, employee.nama AS nama_emp FROM emergency JOIN employee ON emergency.emp_id=employee.id_employee
        WHERE id_employee=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        if ($resultQuery->num_rows == 0) {
            $data['data_index'] = null;
            $data['nama_emergency'] = null;
            $data['alamat'] = null;
            $data['no_telp'] = null;
            $data['hubungan'] = null;
            $data['nama_emp'] = null;

            return $data;
        } else {
            $fetchQuery = $resultQuery->fetch_object();

            $data['data_index'] = $fetchQuery->id_emergency;
            $data['nama_emp'] = $fetchQuery->nama_emp;
            $data['nama_emergency'] = $fetchQuery->nama_emergency;
            $data['alamat'] = $fetchQuery->alamat;
            $data['no_telp'] = $fetchQuery->no_telp;
            $data['hubungan'] = $fetchQuery->hubungan;
            return $data;
        }
    }

    public function update($request)
    {
        $id = $request['idData'];
        $nama = $request['nama'];
        $alamat = $request['alamat'];
        $no_telp = $request['no_telp'];
        $hubungan = $request['hubungan'];

        $sql = "UPDATE emergency SET nama='$nama', alamat='$alamat',
        no_telp='$no_telp', hubungan='$hubungan' WHERE id_emergency=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
