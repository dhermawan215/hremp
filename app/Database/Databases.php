<?php

class Databases
{
    private $host = 'localhost';
    private $user = 'root';
    private $pwd = '';
    private $dbName = 'hrapp_karyawan';

    public function connect()
    {
        // koneksi ke server MySQL
        $mysqli = \mysqli_connect($this->host, $this->user, $this->pwd, $this->dbName);

        // cek koneksi tersambung atau tidak
        if ($mysqli->connect_error) {
            echo "Gagal terkoneksi ke database : (" . $mysqli->connect_error . ")";
        }

        // nilai kembalian bila koneksi berhasil
        return $mysqli;
    }
}
