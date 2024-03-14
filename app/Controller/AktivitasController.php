<?php


namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;

class AktivitasController
{
    protected $db;
    private static $mysqli;
    private static $user;
    public $homeUrl;

    public function __construct()
    {
        session_start();
        $this->db = new Databases;
        static::$mysqli = $this->db->connect();
        $this->homeUrl = new UriController;
        static::$user = $_SESSION['user'];
    }

    public function dataAktivitas($request)
    {
        $url = $this->homeUrl->homeurl();
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_aktivitas) AS counts FROM aktivitas";
        $resultQuery = static::$mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_aktivitas, nama, deskripsi, created_by FROM aktivitas  WHERE nama LIKE '%$search%' OR created_by LIKE '%$search%' ORDER BY id_aktivitas ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_aktivitas) AS counts FROM aktivitas WHERE nama LIKE '%$search%' OR created_by LIKE '%$search%' ORDER BY id_aktivitas ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_aktivitas, nama, deskripsi, created_by FROM aktivitas ORDER BY id_aktivitas ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);
        }

        $response = [];
        $arr = [];

        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id_aktivitas);
            $data['rnum'] = $i;
            $data['name'] = $row->nama;
            $data['deskripsi'] = $row->deskripsi ? $row->deskripsi : 'kosong';
            $data['created_by'] = $row->created_by;
            $data['action'] = '<button id="#btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . $id . '" data-bs-toggle="modal" data-bs-target="#modal-edit-aktivitas"><i class="bi bi-pencil-square"></i></button><button type="button" class="btn btn-sm btn-danger btn-delete ms-1" data-delete="' . $id . '"><i class="bi bi-trash"></i></button><a href="' . $url . '/view/admin-flexy/aktivitas-detail-index.php?activity=' . $id . '&name=' . $row->nama . '" class="btn btn-sm btn-success ms-1"><i class="bi bi-eye"></i></a>';
            $arr[] = $data;
            $i++;
        }

        $response['draw'] = $draw;
        $response['recordsTotal'] = $totalData;
        $response['recordsFiltered'] = $totalFiltered;
        $response['data'] = $arr;

        return $response;
    }

    public function store($request)
    {
        $namaAktivitas = $request['nama'];
        $deskripsiAktivitas = $request['deskripsi'];
        $timestamp = \date('Y-m-d H:i:s');
        $createdBy = static::$user['name'];

        $sql = "INSERT INTO aktivitas(nama,deskripsi,created_by,created_at,updated_at)
        VALUES('$namaAktivitas', '$deskripsiAktivitas', '$createdBy', '$timestamp','$timestamp')";
        $query = static::$mysqli->query($sql);
        return $query;
    }

    public function update($request)
    {
        $id = \base64_decode($request['formValue']);
        $namaAktivitas = $request['nama'];
        $deskripsiAktivitas = $request['deskripsi'];
        $timestamp = \date('Y-m-d H:i:s');
        $sql = "UPDATE aktivitas SET nama='$namaAktivitas',
        deskripsi='$deskripsiAktivitas', updated_at='$timestamp' 
        WHERE id_aktivitas='$id'";
        $query = static::$mysqli->query($sql);
        return $query;
    }

    public function delete($id)
    {
        $ids = \base64_decode($id);
        $sql = "DELETE FROM aktivitas WHERE id_aktivitas='$ids'";
        $query = static::$mysqli->query($sql);
        return $query;
    }
    /**
     * @method to get dropdown activity
     * @return array
     */
    public function getActivityDropdown($request)
    {
        $list = [];

        if (isset($request['search'])) {
            $search = $request['search'];
            $perPage = $request['page'];

            $resultCount = 10;

            $offset = ($perPage - 1) * $resultCount;

            $sqlItem = "SELECT id_aktivitas, nama FROM aktivitas WHERE nama LIKE '%$search%' LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(id_aktivitas) AS count FROM aktivitas WHERE nama LIKE '%$search%' LIMIT 10 OFFSET $offset";
            $mysqli = $this->db->connect();

            $dataItem = $mysqli->query($sqlItem);
            $dataCount = $mysqli->query($sqlCount);

            $counts = $dataCount->fetch_object();
        } else {
            $perPage = $request['page'];

            $resultCount = 10;

            $offset = ($perPage - 1) * $resultCount;

            $sqlItem = "SELECT id_aktivitas, nama FROM aktivitas LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(id_aktivitas) AS count FROM aktivitas LIMIT 10 OFFSET $offset";
            $mysqli = $this->db->connect();

            $dataItem = $mysqli->query($sqlItem);
            $dataCount = $mysqli->query($sqlCount);

            $counts = $dataCount->fetch_object();
        }

        if ($dataItem->num_rows == 0) {
            $list['id'] = 0;
            $list['text'] = "Data Kosong";
            $arr[] = $list;
        }

        while ($row = $dataItem->fetch_object()) {
            $list['id'] = $row->id_aktivitas;
            $list['text'] = $row->nama;
            $arr[] = $list;
        }

        $response['total_count'] = $counts;
        $response['items'] = $arr;

        return $response;
    }
}
