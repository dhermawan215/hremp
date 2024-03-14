<?php


namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;

class AktivitasDetailController
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
    /**
     * @method untuk data table detail aktivitas
     * @return array json
     */
    public function dataAktivitas($request)
    {
        $url = $this->homeUrl->homeurl();
        $activityId = \base64_decode($request['activity']);
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_aktivitas_detail) AS counts FROM aktivitas_detail WHERE aktivitas_id=$activityId";
        $resultQuery = static::$mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_aktivitas_detail, nama_detail FROM aktivitas_detail WHERE aktivitas_id=$activityId AND nama_detail LIKE '%$search%' ORDER BY id_aktivitas_detail ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_aktivitas_detail) AS counts FROM aktivitas_detail WHERE aktivitas_id=$activityId AND nama_detail LIKE '%$search%' ORDER BY id_aktivitas_detail ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_aktivitas_detail, nama_detail FROM aktivitas_detail WHERE aktivitas_id=$activityId ORDER BY id_aktivitas_detail ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);
        }

        $response = [];
        $arr = [];

        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id_aktivitas_detail);
            $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $row->id_aktivitas_detail . '">';
            $data['rnum'] = $i;
            $data['name'] = $row->nama_detail;
            $data['action'] = '<button id="#btn-edit" class="btn btn-sm btn-primary btn-edit" data-edit="' . $id . '" data-bs-toggle="modal" data-bs-target="#modal-edit-aktivitas-detail"><i class="bi bi-pencil-square"></i></button>';
            $arr[] = $data;
            $i++;
        }

        $response['draw'] = $draw;
        $response['recordsTotal'] = $totalData;
        $response['recordsFiltered'] = $totalFiltered;
        $response['data'] = $arr;

        return $response;
    }
    /**
     * @method untuk menyimpan data detail aktivitas
     * @return bool
     */
    public function store($request)
    {
        $name = $request['nama_detail'];
        $activityId = \base64_decode($request['activity']);
        $timestamp = \date('Y-m-d H:i:s');
        $createdBy = static::$user['name'];
        $sql = "INSERT INTO aktivitas_detail(aktivitas_id,nama_detail,created_by,created_at,updated_at)
        VALUES($activityId, '$name', '$createdBy', '$timestamp','$timestamp')";
        $query = static::$mysqli->query($sql);
        return $query;
    }
    /**
     * @method untuk mengupdate data detail aktivitas
     * @return bool
     */
    public function update($request)
    {
        $id = \base64_decode($request['formValue']);
        $name = $request['nama_detail'];
        $timestamp = \date('Y-m-d H:i:s');
        $sql = "UPDATE aktivitas_detail SET nama_detail='$name', updated_at='$timestamp' 
        WHERE id_aktivitas_detail='$id'";
        $query = static::$mysqli->query($sql);
        return $query;
    }
    /**
     * @method untuk menghapus data detail aktivitas
     * @return bool
     */
    public function delete($ids)
    {
        $idsToString = \implode(",", $ids);
        $sql = "DELETE FROM aktivitas_detail WHERE id_aktivitas_detail IN ($idsToString)";
        $query = static::$mysqli->query($sql);
        return $query;
    }

    public function getDetailDropdown($id)
    {
        $list = [];
        $sql = "SELECT id_aktivitas_detail, nama_detail FROM aktivitas_detail WHERE aktivitas_id=$id";
        $query = static::$mysqli->query($sql);

        if ($query->num_rows == 0) {
            $list['id'] = 0;
            $list['text'] = "empty data";
            $arr[] = $list;
        }

        while ($row = $query->fetch_object()) {
            $list['id'] = $row->id_aktivitas_detail;
            $list['text'] = $row->nama_detail;
            $arr[] = $list;
        }

        $response['item'] = $arr;
        return $response;
    }
}
