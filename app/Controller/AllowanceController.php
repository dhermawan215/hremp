<?php


namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
require_once 'DepartmentController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;
use App\Controller\DepartmentController;

class AllowanceController
{
    protected $db;
    private static $mysqli;
    private static $user;
    public $homeUrl;
    private $departemen;

    public function __construct()
    {
        session_start();
        $this->db = new Databases;
        static::$mysqli = $this->db->connect();
        $this->homeUrl = new UriController;
        $this->departemen = new DepartmentController;
        static::$user = $_SESSION['user'];
    }

    public function dataAktivitas($request)
    {
        /**
         * @method untuk datatable di tamppilan user
         * retun json(ajax datatable)
         */
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

    public static function getNomerAllowance()
    {
        /** 
         *  @method  untuk mendapatkan nilai tertinggi dari nomer request allowance
         * dan akan digunakan untuk next request
         * return json (untuk request ajax)
         */
        try {
            //begin transaction
            static::$mysqli->begin_transaction();

            $sqlmax = "SELECT nomer, MAX(id_allowance) as kode FROM allowance GROUP BY nomer, id_allowance ORDER BY id_allowance DESC LIMIT 1";
            $querydb = static::$mysqli->query($sqlmax);
            // commit transaction
            static::$mysqli->commit();
            $fetch = $querydb->fetch_object();
            $idMaxAllowance = $fetch->kode;
            $nomerAllowance = $fetch->nomer;

            $bulanTgl = date('md');
            $huruf = "ARF-";
            //konstanta urutan no 
            // ARF-022700001 
            $urutan = (int) substr($nomerAllowance, 8, 5);
            $urutan++;
            $nomerAllowanceToJson = $huruf . $bulanTgl . sprintf("%05s", $urutan);
            return $data = ['newAllowanceNo' => $nomerAllowanceToJson];
        } catch (\Throwable $th) {
            static::$mysqli->rollback();
            return \null;
        }
    }

    public function save($request)
    {
        $data = [];
        $timestamp = \date('Y-m-d H:i:s');
        $userId = $request['users'];
        $no = $request['nomer'];
        $nama = $request['nama'];
        $departemen = $request['departemen'];
        $hr_approve = 0;
        $manager_approve = 0;

        try {
            //begin transaction
            static::$mysqli->begin_transaction();

            $sql = "INSERT INTO allowance(users_id, nomer, nama, departemen, hr_approve, manager_approve, created_at, updated_at)
             VALUES($userId, '$no','$nama',$departemen,$hr_approve,$manager_approve,'$timestamp','$timestamp')";

            $query = static::$mysqli->query($sql);
            $lastInsertId = static::$mysqli->insert_id;
            $dataInsert = self::lastInsertId($lastInsertId);
            // commit transaction
            static::$mysqli->commit();
            $data['success'] = \true;
            $data['content'] = $dataInsert->nomer;
            return $data;
        } catch (\Throwable $th) {
            static::$mysqli->rollback();
            $data['success'] = \false;
            $data['content'] = \null;
            return $data;
        }
    }

    public static function lastInsertId($id)
    {
        $sql = "SELECT id_allowance, nomer FROM allowance WHERE id_allowance=$id";
        $querydb = static::$mysqli->query($sql);
        $fetch = $querydb->fetch_object();
        return $fetch;
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

    public function departemenDropdown($request)
    {
        /** 
         *  @method  untuk mendapatkan data dropdown dari tabel departemen
         * dan akan digunakan untuk create request
         */
        $departemenData = $this->departemen->getDropdown($request);
        return $departemenData;
    }
}
