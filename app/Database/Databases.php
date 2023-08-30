<?php

namespace App\Database;

use Exception;
use Throwable;

error_reporting(1);
include_once '../protected.php';
class Databases
{
    private $host;
    private $user;
    private $pwd;
    private $dbName;

    public function connect()
    {
        $this->host = 'localhost';
        $this->user = 'root';
        $this->pwd = '';
        $this->dbName = 'hrapp_karyawan';
        // koneksi ke server MySQL
        // $mysqli = \mysqli_connect($this->host, $this->user, $this->pwd, $this->dbName);
        // // cek koneksi tersambung atau tidak
        // if ($mysqli->connect_error) {
        //     die("Internal server error");
        // } else {
        //     return $mysqli;
        // }

        try {
            $mysqli = \mysqli_connect($this->host, $this->user, $this->pwd, $this->dbName);
            return $mysqli;
        } catch (Throwable $th) {
            return throw new Exception("Opps,Something went wrong!!");
        }

        // nilai kembalian bila koneksi berhasil
    }
}
