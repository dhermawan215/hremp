<?php
require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

class EmployeeController
{
    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }

    public function getDataEmployee($request)
    {
        $url = $this->home->homeurl();

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_employee) AS counts FROM employee";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_employee, nip, nama FROM employee JOIN status_emp ON employee.status_emp=status_emp.id_status WHERE nama LIKE '%$search%' ORDER BY id_employee ASC LIMIT $limit OFFSET $offset ";
            $resulData = $mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_employee) AS counts FROM employee JOIN status_emp ON employee.status_emp=status_emp.id_status WHERE nama LIKE '%$search%' ORDER BY id_employee ASC LIMIT $limit OFFSET $offset";
            $resulCountData = $mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_employee, nip, nama, status_name FROM employee JOIN status_emp ON employee.status_emp=status_emp.id_status ORDER BY id_employee ASC LIMIT $limit OFFSET $offset";
            $resulData = $mysqli->query($sqlSearch);
        }

        $response = [];
        if ($resulData->num_rows == 0) {
            $data['rnum'] = "#";
            $data['nip'] = "Data Kosong";
            $data['name'] = "Data Kosong";
            $data['status'] = "Data Kosong";
            $data['action'] = "Data Kosong";
            $arr[] = $data;
        }


        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id_employee);
            $data['rnum'] = $i;
            $data['nip'] = $row->nip;
            $data['name'] = $row->nama;
            $data['status'] = $row->status_name;
            $data['action'] = "<div class='d-flex'><a href='$url/view/pages/status/edit.php?data=$id' class='text-decoration-none align-middle' title='edit'><i class='bi bi-pencil-square'></i></a><button id='btnDelete' class='btndel ms-2 text-danger border-0' data-id='$row->id_employee'><i class='bi bi-trash'></i></button></div>";
            $arr[] = $data;
            $i++;
        }

        $response['draw'] = $draw;
        $response['recordsTotal'] = $totalData;
        $response['recordsFiltered'] = $totalFiltered;
        $response['data'] = $arr;

        return $response;
    }

    public function validateNip($nip)
    {
        $sql = "SELECT nip FROM employee WHERE nip='$nip' LIMIT 1";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery->num_rows;
    }

    public function saveEmployee($request)
    {
        $nip = $request['nip'];
        $status_emp = $request['status_emp'];
        $lokasi = $request['lokasi'];
        $nama = $request['nama'];
        $comp_id = $request['comp_id'];
        $tgl_masuk = $request['tgl_masuk'];
        $email_kantor = $request['email_kantor'];
        $pangkat = $request['pangkat'];
        $jabatan = $request['jabatan'];
        $bpjstk = $request['bpjstk'];
        $bpjskes = $request['bpjskes'];
        $dept_id = $request['dept_id'];
        $is_resigned = 0;

        if (!isset($request['tgl_kartap'])) {
            $sql = "INSERT INTO employee(nip, status_emp, lokasi, nama, comp_id, tgl_masuk, email_kantor, pangkat, jabatan, bpjstk, bpjskes, dept_id, is_resigned)
            VALUES('$nip', $status_emp, '$lokasi', '$nama', $comp_id, '$tgl_masuk', '$email_kantor', '$pangkat', '$jabatan', '$bpjstk', '$bpjskes', $dept_id, $is_resigned)";
        } else {
            $tgl_kartap = $request['tgl_kartap'];
            $sql = "INSERT INTO employee(nip, status_emp, lokasi, nama, comp_id, tgl_masuk, tgl_kartap, email_kantor, pangkat, jabatan, bpjstk, bpjskes, dept_id, is_resigned)
        VALUES('$nip', $status_emp, '$lokasi', '$nama', $comp_id, '$tgl_masuk', '$tgl_kartap', '$email_kantor', '$pangkat', '$jabatan', '$bpjstk', '$bpjskes', $dept_id, $is_resigned)";
        }

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);
        $lastId = $mysqli->insert_id;

        if ($resultQuery == true) {
            $dataSaved = $this->getDataSave($lastId);
            $data['status'] = $resultQuery;
            $data['content'] = $dataSaved;
            return $data;
        } else {
            $data['status'] = $resultQuery;
            return $data;
        }
    }

    public function getDataSave($id)
    {
        $sql = "SELECT id_employee,status_emp,nama FROM employee WHERE id_employee=$id LIMIT 1";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        if ($resultQuery->num_rows == 0) {

            $data['id'] = null;
            $data['status'] = null;
            $data['nama'] = null;

            return $data;
        } else {
            $fetchQuery = $resultQuery->fetch_object();

            $data['id'] = base64_encode($fetchQuery->id_employee);
            $data['status'] = base64_encode($fetchQuery->status_emp);
            $data['nama'] = $fetchQuery->nama;

            return $data;
        }
    }

    public function saveEmployeePersonal($request)
    {
        $emp_id = $request['emp_id'];
        $tempat_lahir = $request['tempat_lahir'];
        $tanggal_lahir = $request['tanggal_lahir'];
        $status_pernikahan = $request['status_pernikahan'];
        $golongan_darah = $request['golongan_darah'];
        $agama = $request['agama'];
        $gender = $request['gender'];
        $nik = $request['nik'];
        $email = $request['email'];
        $no_hp = $request['no_hp'];
        $domisili = $request['domisili'];

        $sql = "INSERT INTO emp_personal(emp_id,tempat_lahir,tanggal_lahir,status_pernikahan,golongan_darah,agama,gender,nik,email,no_hp,domisili)
        VALUES($emp_id, '$tempat_lahir', '$tanggal_lahir', '$status_pernikahan', '$golongan_darah', '$agama', '$gender', '$nik', '$email', '$no_hp', '$domisili')";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }

    public function employeePersonalAddress($request)
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
    public function employeePersonalEdu($request)
    {
        $emp_id = $request['emp_id'];
        $pendidikan_terakhir = $request['pendidikan_terakhir'];
        $jurusan = $request['jurusan'];
        $asal_sekolah = $request['asal_sekolah'];

        $sql = "INSERT INTO education(emp_id,pendidikan_terakhir,jurusan,asal_sekolah)
        VALUES($emp_id, '$pendidikan_terakhir', '$jurusan', '$asal_sekolah')";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }

    public function employeeFamily($request)
    {
        $emp_id = $request['emp_id'];
        $nama_suami_istri = $request['nama_suami_istri'];
        $anak1 = $request['anak1'];
        $anak2 = $request['anak2'];
        $anak3 = $request['anak3'];
        $anak4 = $request['anak4'];

        $sql = "INSERT INTO emp_families(emp_id,nama_suami_istri,anak1,anak2,anak3,anak4)
        VALUES($emp_id, '$nama_suami_istri', '$anak1', '$anak2', '$anak3', '$anak4')";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }

    public function employeeEmergency($request)
    {
        $emp_id = $request['emp_id'];
        $nama = $request['nama'];
        $alamat = $request['alamat'];
        $no_telp = $request['no_telp'];
        $hubungan = $request['hubungan'];

        $sql = "INSERT INTO emergency(emp_id,nama,alamat,no_telp,hubungan)
        VALUES($emp_id, '$nama', '$alamat', '$no_telp', '$hubungan')";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
