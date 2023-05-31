<?php
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
        $mysqli = \mysqli_connect($this->host, $this->user, $this->pwd, $this->dbName);
        // cek koneksi tersambung atau tidak
        if ($mysqli->error) {
            echo "database not connect";
        } else {
            return $mysqli;
        }

        // nilai kembalian bila koneksi berhasil
    }
}
