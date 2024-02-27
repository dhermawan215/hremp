<?php


namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;

class AllowanceController
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
            $sqlSearch = "SELECT id_aktivitas, nama, created_by FROM aktivitas  WHERE nama LIKE '%$search%' OR created_by LIKE '%$search%' ORDER BY id_aktivitas ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_aktivitas) AS counts FROM aktivitas WHERE nama LIKE '%$search%' OR created_by LIKE '%$search%' ORDER BY id_aktivitas ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_aktivitas, nama, created_by FROM aktivitas ORDER BY id_aktivitas ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);
        }

        $response = [];
        $arr = [];

        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id_aktivitas);
            $data['rnum'] = $i;
            $data['name'] = $row->nama;
            $data['created_by'] = $row->created_by;
            $data['action'] = '<button id="#btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . $id . '" data-bs-toggle="modal" data-bs-target="#modal-edit-aktivitas">Edit</button><button type="submit" class="btn btn-sm btn-danger btn-delete ms-1" data-delete="' . $id . '">Delete</button>';
            $arr[] = $data;
            $i++;
        }

        $response['draw'] = $draw;
        $response['recordsTotal'] = $totalData;
        $response['recordsFiltered'] = $totalFiltered;
        $response['data'] = $arr;

        return $response;
    }

    public function save($request)
    {
        //query no sample request
        $sqlmax = "SELECT MAX(id_allowance) as kode FROM allowance";
        $querydb = static::$mysqli->query($sqlmax);
        $fetch = $querydb->fetch_object();
        // get last id from db
        $kodeAllowance = $fetch->kode;
        // select last no_sample
        $sqlgetno = "SELECT no FROM allowance where id_allowance=$kodeAllowance";
        $querydb2 = static::$mysqli->query($sqlgetno);
        $fetch2 = $querydb2->fetch_object();
        $lastAllowanceNoFromDb = $fetch2->no;

        $bulanTgl = date('md');
        $huruf = "ARF-";
        //urutan no sampelnya
        // ARF-1011001
        $urutan = (int) substr($lastAllowanceNoFromDb, 9, 3);
        $urutan++;
        $no = $huruf . $bulanTgl . sprintf("%04s", $urutan);

        $timestamp = \date('Y-m-d H:i:s');
        $userId = $request['users'];
        $no = $request['no'];
        $nama = $request['nama'];
        $departemen = $request['departemen'];
        $total = $request['total'];
        $hr_approve = 0;
        $manager_approve = 0;

        $sql = "INSERT INTO allowance(users_id,no,nama,departemen,total,hr_approve,manager_approve,created_at,updated_at)
        VALUES('$userId','$no',$nama,$departemen,'$total','$hr_approve','$manager_approve','$timestamp','$timestamp')";

        $query = static::$mysqli->query($sql);
        return $query;
    }

    public function update($request)
    {
        $id = \base64_decode($request['formValue']);
        $namaAktivitas = $request['nama'];
        $timestamp = \date('Y-m-d H:i:s');
        $sql = "UPDATE aktivitas SET nama='$namaAktivitas', updated_at='$timestamp' 
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
}
