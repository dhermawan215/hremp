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
}
