<?php

namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
require_once 'AktivitasController.php';
require_once 'AktivitasDetailController.php';

include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;
use App\Controller\AktivitasController;
use App\Controller\AktivitasDetailController;

class AllowanceDetailController
{
    protected $db;
    private static $mysqli;
    private static $user;
    public $homeUrl;
    private $aktivitas;
    private $aktivitasDetail;

    public function __construct()
    {
        session_start();
        $this->db = new Databases;
        static::$mysqli = $this->db->connect();
        $this->homeUrl = new UriController;
        $this->aktivitas = new AktivitasController;
        $this->aktivitasDetail = new AktivitasDetailController;
        static::$user = $_SESSION['user'];
    }

    public function dropdownActivity($request)
    {
        return $this->aktivitas->getActivityDropdown($request);
    }

    public function dropdownActivityDetail($request)
    {
        return $this->aktivitasDetail->getDetailDropdown($request['activity']);
    }

    /**
     * function save
     * @method untuk simpan data allowance request
     * @return bool
     */
    public function save($request)
    {
        $data = [];
        $timestamp = \date('Y-m-d H:i:s');
        $allowance_id = $request['allowance'];
        $activity = $request['activity'];
        $activity_detail = $request['activity_detail'];
        $deskripsi = $request['deskripsi'];
        $jumlah_biaya_bon = $request['jumlah_biaya_bon'];
        $jumlah_biaya_klaim = $request['jumlah_biaya_klaim'];
        $tanggal_aktivitas = $request['tanggal_aktivitas'];

        try {
            //begin transaction
            static::$mysqli->begin_transaction();

            $sql = "INSERT INTO allowance_detail(allowance_id, aktivitas_id, aktivitas_detail_id, deskripsi, jumlah_biaya_bon, jumlah_biaya_klaim, tanggal_aktivitas, created_at, updated_at)
            VALUES($allowance_id, $activity,$activity_detail, '$deskripsi',
            $jumlah_biaya_bon, $jumlah_biaya_klaim, '$tanggal_aktivitas', '$timestamp','$timestamp')";

            $query = static::$mysqli->query($sql);
            // commit transaction
            static::$mysqli->commit();
            $data['success'] = \true;
            return $data;
        } catch (\Throwable $th) {
            static::$mysqli->rollback();
            $data['success'] = \false;
            return $data;
        }
    }
}
