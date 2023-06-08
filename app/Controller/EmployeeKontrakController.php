<?php

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

class EmployeeKontrakController
{
    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }

    public function store($request)
    {
        $emp_id = $request['emp_id'];
        $awal_kontrak = $request['awal_kontrak'];
        $akhir_kontrak = $request['akhir_kontrak'];
        $keterangan = $request['keterangan'];

        $sql = "INSERT INTO kontrak_kerja(emp_id,awal_kontrak,akhir_kontrak,keterangan)
        VALUES($emp_id, '$awal_kontrak', '$akhir_kontrak', '$keterangan')";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
