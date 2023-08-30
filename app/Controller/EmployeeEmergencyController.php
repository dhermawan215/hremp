<?php

namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

use App\Database\Databases;
use App\Controller\UriController;

class EmployeeEmergencyController
{
    public function __construct()
    {
        $this->db = new Databases;
        $this->home = new UriController;
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
        $sql = "SELECT * FROM emergency
        WHERE id_emergency=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        if ($resultQuery->num_rows == 0) {
            $data['data_index'] = null;
            $data['nama_emergency'] = null;
            $data['alamat'] = null;
            $data['no_telp'] = null;
            $data['hubungan'] = null;
            return $data;
        } else {
            $fetchQuery = $resultQuery->fetch_object();

            $data['data_index'] = $fetchQuery->id_emergency;
            $data['nama_emergency'] = $fetchQuery->nama_emergency;
            $data['alamat'] = $fetchQuery->alamat;
            $data['no_telp'] = $fetchQuery->no_telp;
            $data['hubungan'] = $fetchQuery->hubungan;
            return $data;
        }
    }

    public function update($request)
    {
        $id = base64_decode($request['idData']);
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

    // fungsi untuk menyediakan data ke datatable
    public function getDataKontakDarurat($request)
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $id = $request['empId'];

        $sqlcountTotalData = "SELECT COUNT(id_emergency) AS counts FROM emergency WHERE emp_id=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;


        $sqlData = "SELECT e.id_emergency, e.alamat,e.nama AS namesemp, e.no_telp, e.hubungan, e.emp_id, id_employee FROM emergency AS e JOIN employee ON e.emp_id=employee.id_employee
        WHERE id_employee = $id LIMIT $limit OFFSET $offset";

        $mysqli = $this->db->connect();
        $resultData = $mysqli->query($sqlData);

        $response = [];
        $data = [];
        // return $fetchQuery;
        if ($resultData->num_rows == 0) {
            // $data['rnum'] = "#";
            $data['nama'] = "Data Kosong";
            $data['alamat'] = "Data Kosong";
            $data['no_telp'] = "Data Kosong";
            $data['hubungan'] = "Data Kosong";
            $arr[] = $data;
        } else {

            while ($row = $resultData->fetch_object()) {
                // $data['rnum'] = $i;
                $data['nama'] = $row->namesemp ? $row->namesemp : "Data Kosong";
                $data['alamat'] = $row->alamat ? $row->alamat : "Data Kosong";
                $data['no_telp'] = $row->no_telp ? $row->no_telp : "Data Kosong";
                $data['hubungan'] = $row->hubungan ? $row->hubungan : "Data Kosong";
                $data['data_index'] = base64_encode($row->id_emergency);

                $data['action'] = '<button type="button" id="" class="btn btn-sm btn-primary btnedit" data-bs-toggle="modal" data-bs-target="#modalEditKontakDarurat">Edit</button>';

                $i++;
                $arr[] = $data;
            }
        }

        $response['draw'] = $draw;
        $response['recordsTotal'] = $totalData;
        $response['recordsFiltered'] = $totalFiltered;
        $response['data'] = $arr;

        return $response;
    }
}
