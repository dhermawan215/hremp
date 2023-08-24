<?php

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

class EmployeePengalamanController
{
    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }

    // fungsi menampilkan data pengalaman kerja di tabel
    public function getDataPengalaman($request)
    {

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $id = $request['empId'];

        $sqlcountTotalData = "SELECT COUNT(id_pengalaman) AS counts FROM pengalaman_kerja WHERE emp_id=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;


        $sqlData = "SELECT * FROM pengalaman_kerja WHERE emp_id=$id LIMIT $limit OFFSET $offset";

        $mysqli = $this->db->connect();
        $resultData = $mysqli->query($sqlData);

        $response = [];
        $data = [];
        // return $fetchQuery;
        if ($resultData->num_rows == 0) {
            $data['perusahaan'] = "Data Kosong";
            $data['jabatan'] = "Data Kosong";
            $data['periode_masuk'] = "Data Kosong";
            $data['periode_keluar'] = "Data Kosong";
            $data['keterangan'] = "Data Kosong";
            $data['action'] = "#";
            $arr[] = $data;
        } else {

            while ($row = $resultData->fetch_object()) {
                $data['perusahaan'] = $row->perusahaan ? $row->perusahaan : "Data Kosong";
                $data['jabatan'] = $row->jabatan ? $row->jabatan : "Data Kosong";
                $data['periode_masuk'] = $row->periode_masuk ? $row->periode_masuk : "Data Kosong";
                $data['periode_keluar'] = $row->periode_keluar ? $row->periode_keluar : "Data Kosong";
                $data['keterangan'] = $row->keterangan ? $row->keterangan : "Data Kosong";
                $data['data_index'] = $row->id_pengalaman ? base64_encode($row->id_pengalaman) : null;

                $data['action'] = '<div class="d-flex"><button type="button" id="" class="btn btn-sm btn-primary btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditPengalamanKerja">Edit</button><button type="button" class="btnDelete btn btn-sm btn-danger ms-2" data-button=' . base64_encode($row->id_pengalaman) . '>Delete</button></div>';

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

    // fungsi simpan pengalaman kerja
    public function store($request)
    {
        $emp_id = $request['emp_id'];
        $perusahaan = $request['perusahaan'];
        $jabatan = $request['jabatan'];
        $masuk = $request['periode_masuk'];
        $keluar = $request['periode_keluar'];
        $ket = $request['keterangan'];

        // sql simpan data
        $sql = "INSERT INTO pengalaman_kerja(emp_id, perusahaan, jabatan, periode_masuk, periode_keluar, keterangan)
        VALUES($emp_id, '$perusahaan', '$jabatan', '$masuk', '$keluar', '$ket')";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }

    // fungsu update pengalaman kerja
    public function update($request)
    {
        $id = base64_decode($request['idData']);
        $perusahaan = $request['perusahaan'];
        $jabatan = $request['jabatan'];
        $masuk = $request['periode_masuk'];
        $keluar = $request['periode_keluar'];
        $ket = $request['keterangan'];

        $sqlUpdate = "UPDATE pengalaman_kerja SET
        perusahaan='$perusahaan', jabatan='$jabatan', periode_masuk='$masuk',
        periode_keluar='$keluar', keterangan='$ket' WHERE id_pengalaman=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlUpdate);

        return $resultQuery;
    }

    // fungsi hapus data
    public function delete($request)
    {
        //decode id
        $id = base64_decode($request['ids']);

        //query delete
        $sqlDelete = "DELETE FROM pengalaman_kerja WHERE id_pengalaman=$id";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlDelete);

        return $resultQuery;
    }
}
