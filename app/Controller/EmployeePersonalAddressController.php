<?php

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

class EmployeePersonalAddressController
{
    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }

    public function store($request)
    {
        $emp_id = $request['emp_id'];
        $alamat_ktp = $request['alamat_ktp'];
        $kelurahan = $request['kelurahan'];
        $rt = $request['rt'];
        $rw = $request['rw'];
        $kecamatan = $request['kecamatan'];
        $kota = $request['kota'];
        $provinsi = $request['provinsi'];
        $alamat_lengkap = $request['alamat_lengkap'];
        $no_telp = $request['no_telp'];

        $sql = "INSERT INTO emp_personal_address(emp_id,alamat_ktp,rt,rw,kelurahan,kecamatan,kota,provinsi,alamat_lengkap,no_telp)
        VALUES($emp_id, '$alamat_ktp', '$rt', '$rw', '$kelurahan', '$kecamatan', '$kota', '$provinsi', '$alamat_lengkap', '$no_telp' )";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }

    public function show($id)
    {
        $sql = "SELECT id_address,emp_id,id_employee,nama,alamat_ktp,rt,rw,kelurahan,kecamatan,kota,provinsi,alamat_lengkap,no_telp
        FROM emp_personal_address JOIN employee ON emp_personal_address.emp_id=employee.id_employee WHERE emp_id=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        if ($resultQuery->num_rows == 0) {
            $data['data_index'] = null;
            $data['nama'] = null;
            $data['alamat_ktp'] = null;
            $data['rt'] = null;
            $data['rw'] = null;
            $data['kelurahan'] = null;
            $data['kecamatan'] = null;
            $data['kota'] = null;
            $data['provinsi'] = null;
            $data['alamat_lengkap'] = null;
            $data['no_telp'] = null;
            return $data;
        } else {
            $fetchQuery = $resultQuery->fetch_object();

            $data['data_index'] = $fetchQuery->id_address;
            $data['nama'] = $fetchQuery->nama;
            $data['alamat_ktp'] = $fetchQuery->alamat_ktp;
            $data['rt'] = $fetchQuery->rt;
            $data['rw'] = $fetchQuery->rw;
            $data['kelurahan'] = $fetchQuery->kelurahan;
            $data['kecamatan'] = $fetchQuery->kecamatan;
            $data['kota'] = $fetchQuery->kota;
            $data['provinsi'] = $fetchQuery->provinsi;
            $data['alamat_lengkap'] = $fetchQuery->alamat_lengkap;
            $data['no_telp'] = $fetchQuery->no_telp ? $fetchQuery->no_telp : null;
            return $data;
        }
    }

    public function update($request)
    {
        $id = $request['idData'];
        $emp_id = $request['emp_id'];
        $alamat_ktp = $request['alamat_ktp'];
        $kelurahan = $request['kelurahan'];
        $rt = $request['rt'];
        $rw = $request['rw'];
        $kecamatan = $request['kecamatan'];
        $kota = $request['kota'];
        $provinsi = $request['provinsi'];
        $alamat_lengkap = $request['alamat_lengkap'];
        $no_telp = $request['no_telp'];

        $sql = "UPDATE emp_personal_address SET alamat_ktp='$alamat_ktp',
        kelurahan='$kelurahan', rt='$rt', rw='$rw', kecamatan='$kecamatan', kota='$kota',
        provinsi='$provinsi', alamat_lengkap='$alamat_lengkap', no_telp='$no_telp' WHERE id_address=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
