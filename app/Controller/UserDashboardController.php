<?php


namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;

class UserDashboardController
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
    //bikin function sendiri
    public function limitEmployee()
    {
        $userID = static::$user['idusers'];
        $sqlActive = "SELECT saldo_awal, saldo_sisa  FROM allowance_wallet WHERE users_id='$userID'";
        $mysqli = $this->db->connect();
        $result = $mysqli->query($sqlActive);
        $fetch = $result->fetch_object();
        return $fetch;
    }
    //function sampai sini
}
