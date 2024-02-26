<?php

namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;

class AllowanceLimitController
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

    public function dataLimit($request)
    {
        /*function to get data for datatable
        * @return array
        */
        $url = $this->homeUrl->homeurl();
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_allowance_limit) AS counts FROM allowance_limit";
        $resultQuery = static::$mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_allowance_limit, nama_limit, saldo_limit FROM allowance_limit  WHERE nama_limit LIKE '%$search%' OR saldo_limit LIKE '%$search%' ORDER BY id_allowance_limit ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_allowance_limit) AS counts FROM allowance_limit WHERE nama_limit LIKE '%$search%' OR saldo_limit LIKE '%$search%' ORDER BY id_allowance_limit ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_allowance_limit, nama_limit, saldo_limit FROM allowance_limit ORDER BY id_allowance_limit ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);
        }

        $response = [];
        $arr = [];

        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id_allowance_limit);
            $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $row->id_allowance_limit . '">';
            $data['rnum'] = $i;
            $data['name'] = $row->nama_limit;
            $data['limit_value'] = $row->saldo_limit;
            $data['limit'] = 'Rp. ' . \number_format($row->saldo_limit, 0, ',', '.');
            $data['action'] = '<button id="#btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . $id . '" data-bs-toggle="modal" data-bs-target="#modal-edit-allowance-limit">Edit</button>';
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
        /*function to save data 
        * @return bool
        */
        $namaLimit = $request['nama_limit'];
        $timestamp = \date('Y-m-d H:i:s');
        $saldoLimit = $request['saldo_limit'];

        $sql = "INSERT INTO allowance_limit(nama_limit,saldo_limit,created_at,updated_at)
        VALUES('$namaLimit', '$saldoLimit', '$timestamp','$timestamp')";
        $query = static::$mysqli->query($sql);
        return $query;
    }

    public function update($request)
    {
        $id = \base64_decode($request['formValue']);
        $namaLimit = $request['nama_limit'];
        $timestamp = \date('Y-m-d H:i:s');
        $saldoLimit = $request['saldo_limit'];

        $sql = "UPDATE allowance_limit SET nama_limit='$namaLimit',
        saldo_limit=$saldoLimit, updated_at='$timestamp' WHERE id_allowance_limit=$id";
        $query = static::$mysqli->query($sql);
        return $query;
    }

    public function delete($ids)
    {
        /*function to delete data 
        * @return bool
        */
        $idsToString = \implode(",", $ids);
        $sql = "DELETE FROM allowance_limit WHERE id_allowance_limit IN ($idsToString)";
        $query = static::$mysqli->query($sql);
        return $query;
    }

    public function getDropdown($request)
    {
        $list = [];

        if (isset($request['search'])) {
            $search = $request['search'];
            $perPage = $request['page'];

            $resultCount = 10;

            $offset = ($perPage - 1) * $resultCount;

            $sqlItem = "SELECT id_allowance_limit, nama_limit FROM allowance_limit WHERE nama_limit LIKE '%$search%' LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(id_allowance_limit) AS count FROM allowance_limit WHERE nama_limit LIKE '%$search%' LIMIT 10 OFFSET $offset";

            $dataItem = static::$mysqli->query($sqlItem);
            $dataCount = static::$mysqli->query($sqlCount);

            $counts = $dataCount->fetch_object();
        } else {
            $perPage = $request['page'];

            $resultCount = 10;

            $offset = ($perPage - 1) * $resultCount;

            $sqlItem = "SELECT id_allowance_limit, nama_limit FROM allowance_limit LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(id_allowance_limit) AS count FROM allowance_limit LIMIT 10 OFFSET $offset";

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
            $list['id'] = $row->id_allowance_limit;
            $list['text'] = $row->nama_limit;
            $arr[] = $list;
        }

        $response['total_count'] = $counts;
        $response['items'] = $arr;

        return $response;
    }

    public function limitCallback($id)
    {
        $sql = "SELECT saldo_limit FROM allowance_limit WHERE id_allowance_limit=$id";

        $query = static::$mysqli->query($sql);
        $saldoLimit = $query->fetch_object();

        return $saldoLimit;
    }
}
