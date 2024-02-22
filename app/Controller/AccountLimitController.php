<?php


namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
require_once 'EmployeeController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;
use App\Controller\EmployeeController;

class AccountLimitController
{
    protected $db;
    private static $mysqli;
    public $homeUrl;

    public function __construct()
    {
        $this->db = new Databases;
        static::$mysqli = $this->db->connect();
        $this->homeUrl = new UriController;
    }

    public function dataAcountWallet($request)
    {
        $url = $this->homeUrl->homeurl();
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id) AS counts FROM allowance_wallet";
        $resultQuery = static::$mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id, employee.nama AS nama_karyawan, employee.pangkat, saldo_awal, periode_saldo, employee_id
            FROM allowance_wallet JOIN users ON allowance_wallet.users_id=users.id_users 
            JOIN employee ON users.employee_id=employee.id_employee  WHERE employee.nama LIKE '%$search%' OR employee.pangkat LIKE '%$search%' OR saldo_awal LIKE '%$search%' ORDER BY employee.nama ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id) AS counts FROM allowance_wallet JOIN users ON allowance_wallet.users_id=users.id_users 
            JOIN employee ON users.employee_id=employee.id_employee  WHERE employee.nama LIKE '%$search%' OR employee.pangkat LIKE '%$search%' OR saldo_awal LIKE '%$search%' ORDER BY employee.nama ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id, employee.nama AS nama_karyawan, employee.pangkat, saldo_awal, periode_saldo, employee_id
            FROM allowance_wallet JOIN users ON allowance_wallet.users_id=users.id_users 
            JOIN employee ON users.employee_id=employee.id_employee ORDER BY employee.nama ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);
        }

        $response = [];
        $arr = [];

        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id);
            $idEmployee = base64_encode($row->employee_id);
            $data['rnum'] = $i;
            $data['name'] = $row->nama_karyawan;
            $data['pangkat'] = $row->pangkat;
            $data['saldo_awal'] = 'Rp. ' . \number_format($row->saldo_awal, 0, ',', '.');
            $data['periode'] = $row->periode_saldo;
            $data['action'] = '<button id="#btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . $id . '" data-bs-toggle="modal" data-bs-target="#modal-edit-aktivitas">Edit Tunjangan</button><button type="submit" class="btn btn-sm btn-danger btn-delete ms-1" data-emp="' . $idEmployee . '" data-delete="' . $id . '">Reset</button>';
            $arr[] = $data;
            $i++;
        }

        $response['draw'] = $draw;
        $response['recordsTotal'] = $totalData;
        $response['recordsFiltered'] = $totalFiltered;
        $response['data'] = $arr;

        return $response;
    }

    public function userEmployee($request)
    {
        $list = [];

        if (isset($request['search'])) {
            $search = $request['search'];
            $perPage = $request['page'];

            $resultCount = 10;

            $offset = ($perPage - 1) * $resultCount;

            $sqlItem = "SELECT id_users, employee.nama AS nama_karyawan FROM users JOIN employee ON users.employee_id=employee.id_employee WHERE nama_karyawan LIKE '%$search%' LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(id_users) AS count FROM users JOIN employee ON users.employee_id=employee.id_employee WHERE nama_karyawan LIKE '%$search%' LIMIT 10 OFFSET $offset";

            $dataItem = static::$mysqli->query($sqlItem);
            $dataCount = static::$mysqli->query($sqlCount);

            $counts = $dataCount->fetch_object();
        } else {
            $perPage = $request['page'];

            $resultCount = 10;

            $offset = ($perPage - 1) * $resultCount;

            $sqlItem = "SELECT id_users, employee.nama AS nama_karyawan FROM users JOIN employee ON users.employee_id=employee.id_employee LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(id_users) AS count FROM users JOIN employee ON users.employee_id=employee.id_employee LIMIT 10 OFFSET $offset";

            $dataItem = static::$mysqli->query($sqlItem);
            $dataCount = static::$mysqli->query($sqlCount);

            $counts = $dataCount->fetch_object();
        }

        if ($dataItem->num_rows == 0) {
            $list['id'] = 0;
            $list['text'] = "Data Kosong";
            $arr[] = $list;
        }

        while ($row = $dataItem->fetch_object()) {
            $list['id'] = $row->id_users;
            $list['text'] = $row->nama_karyawan;
            $arr[] = $list;
        }

        $response['total_count'] = $counts;
        $response['items'] = $arr;

        return $response;
    }

    public function save($request)
    {
        $userId = $request['users'];
        $saldoAwal = $request['saldo_awal'];
        $periodeSaldo = $request['periode_saldo'];
        $timestamp = \date('Y-m-d H:i:s');

        $sql = "INSERT INTO allowance_wallet(users_id,saldo_awal,saldo_sisa,periode_saldo,created_at,updated_at)
        VALUES('$userId',$saldoAwal,$saldoAwal,'$periodeSaldo','$timestamp','$timestamp')";

        $query = static::$mysqli->query($sql);
        return $query;
    }

    public function editTunjangan($request)
    {
        // jika edit pangkat true, maka data pangkat di ubah
        $data = [];
        $data['employee'] = $request['employee'];
        $data['pangkat'] = $request['pangkat'];
        $editPangkat = EmployeeController::editPangkat($request);
    }
}
