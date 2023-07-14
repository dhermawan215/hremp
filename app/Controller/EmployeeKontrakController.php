<?php

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

class EmployeeKontrakController
{
    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }

    public function store($request)
    {
        $emp_id = $request['emp_id'];
        $awal_kontrak = $request['awal_kontrak'];
        $akhir_kontrak = $request['akhir_kontrak'];
        $keterangan = $request['keterangan'];

        $sql = "INSERT INTO kontrak_kerja(emp_id,awal_kontrak,akhir_kontrak,keterangan)
        VALUES($emp_id, '$awal_kontrak', '$akhir_kontrak', '$keterangan')";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }

    public function showTableData($request)
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $id = $request['empId'];

        $sqlcountTotalData = "SELECT COUNT(id_kontrak) AS counts FROM kontrak_kerja WHERE emp_id=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;


        $sqlData = "SELECT id_kontrak, awal_kontrak, akhir_kontrak, keterangan, emp_id, id_employee, nama, status_emp, id_status, status_name
        FROM kontrak_kerja RIGHT JOIN employee ON kontrak_kerja.emp_id=employee.id_employee
        JOIN status_emp ON employee.status_emp=status_emp.id_status WHERE id_employee=$id LIMIT $limit OFFSET $offset";

        $mysqli = $this->db->connect();
        $resultData = $mysqli->query($sqlData);

        $response = [];
        $data = [];
        // return $fetchQuery;
        if ($resultData->num_rows == 0) {
            $data['rnum'] = "#";
            $data['awal_kontrak'] = "Data Kosong";
            $data['akhir_kontrak'] = "Data Kosong";
            $data['keterangan'] = "Data Kosong";
            $data['status_name'] = "Data Kosong";
            $arr[] = $data;
        } else {

            while ($row = $resultData->fetch_object()) {
                $data['rnum'] = $i;
                $data['awal_kontrak'] = $row->awal_kontrak ? $row->awal_kontrak : "Data Kosong";
                $data['akhir_kontrak'] = $row->akhir_kontrak ? $row->akhir_kontrak : "Data Kosong";
                $data['keterangan'] = $row->keterangan ? $row->keterangan : "Data Kosong";
                $data['data_index'] = $row->id_kontrak ? base64_encode($row->id_kontrak) : null;
                if ($row->status_emp != 1) {
                    $data['action'] = '<button type="button" id="" class="btn btn-sm btn-primary btn-edit" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>';
                } else {
                    $data['action'] = "Data Kosong";
                }
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

    public function update($request)
    {

        $id = base64_decode($request['idData']);
        $awal_kontrak = $request['awal_kontrak'];
        $akhir_kontrak = $request['akhir_kontrak'];
        $keterangan = $request['keterangan'];

        $sql = "UPDATE kontrak_kerja SET awal_kontrak='$awal_kontrak', akhir_kontrak='$akhir_kontrak', keterangan='$keterangan' WHERE id_kontrak=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }

    public function show($id)
    {
        $sqlData = "SELECT id_kontrak, awal_kontrak, akhir_kontrak, keterangan, emp_id, id_employee, nama, status_emp, id_status, status_name
        FROM kontrak_kerja RIGHT JOIN employee ON kontrak_kerja.emp_id=employee.id_employee
        JOIN status_emp ON employee.status_emp=status_emp.id_status WHERE id_employee=$id LIMIT 1";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlData);


        if ($resultQuery->num_rows == 0) {
            $data['nama'] = null;
            return $data;
        } else {
            $fetchQuery = $resultQuery->fetch_object();
            $data['nama'] = $fetchQuery->nama;
            if ($fetchQuery->status_emp == 1) {
                $data['content'] = '<div class="m-2 p-2 alert alert-danger" role="alert">Karyawan berstatus: ' . $fetchQuery->status_name . '</div>';
            } else {
                $data['content'] = '<div class="m-2 p-2 alert alert-primary" role="alert">Karyawan berstatus: ' . $fetchQuery->status_name . '</div>';
            }
            return $data;
        }
    }
}
