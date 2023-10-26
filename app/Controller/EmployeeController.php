<?php

namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

use App\Database\Databases;
use App\Controller\UriController;

class EmployeeController
{
    private $mutasi = 1;
    private $rotasi = 2;
    private $promosi = 3;
    private $demosi = 4;
    private $db;
    public $home;

    public function __construct()
    {
        $this->db = new Databases;
        $this->home = new UriController;
    }

    public function getDataEmployee($request)
    {
        $url = $this->home->homeurl();

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_employee) AS counts FROM employee WHERE is_resigned='0'";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_employee, nip, nama, status_name FROM employee JOIN status_emp ON employee.status_emp=status_emp.id_status WHERE is_resigned='0' AND nama LIKE '%$search%' OR nip LIKE '%$search%' ORDER BY id_employee ASC LIMIT $limit OFFSET $offset ";
            $resulData = $mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_employee) AS counts FROM employee JOIN status_emp ON employee.status_emp=status_emp.id_status WHERE is_resigned='0'AND  nama LIKE '%$search%' OR nip LIKE '%$search%' ORDER BY id_employee ASC LIMIT $limit OFFSET $offset";
            $resulCountData = $mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_employee, nip, nama, status_name FROM employee JOIN status_emp ON employee.status_emp=status_emp.id_status WHERE is_resigned='0' ORDER BY id_employee ASC LIMIT $limit OFFSET $offset";
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
            $data['index'] = base64_encode($id);
            $data['nip'] = $row->nip;
            $data['name'] = $row->nama;
            $data['status'] = $row->status_name;
            $data['action'] = "<div class='d-flex'><a href='$url/view/pages/employee/view-employee.php?dataId=$id' class='text-decoration-none align-middle' title='edit'><i class='bi bi-eye-fill'></i></a><button id='btnResigned' class='btnresigned ms-2 text-danger border-0' data-id='$row->id_employee' title='resign' data-bs-toggle='modal' data-bs-target='#modalIsResigned' ><i class='bi bi-box-arrow-right'></i></button><a href='$url/view/pages/employee/employee-mutasi.php?karyawan=$id' title='mutasi' class='ms-2' ><i class='bi bi-toggles'></i></a></div>";
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
        $sql = "SELECT id_employee,status_emp,nama, status_name FROM employee JOIN status_emp ON employee.status_emp=status_emp.id_status WHERE id_employee=$id LIMIT 1";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        if ($resultQuery->num_rows == 0) {

            $data['id'] = null;
            $data['status'] = null;
            $data['nama'] = null;
            $data['status_name'] = null;

            return $data;
        } else {
            $fetchQuery = $resultQuery->fetch_object();

            $data['id'] = base64_encode($fetchQuery->id_employee);
            $data['status'] = base64_encode($fetchQuery->status_emp);
            $data['nama'] = $fetchQuery->nama;
            $data['status_name'] = $fetchQuery->status_name;

            return $data;
        }
    }

    public function show($id)
    {
        $sql = "SELECT id_employee,nip,status_emp,status_name,lokasi,nama,comp_id,company_name,tgl_masuk,tgl_kartap,email_kantor,pangkat,jabatan,
        bpjstk,bpjskes,dept_id,dept_name,is_resigned
        FROM employee JOIN status_emp ON employee.status_emp=status_emp.id_status JOIN company ON employee.comp_id=company.IdCompany JOIN department ON employee.dept_id=department.id_dept
        WHERE id_employee=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        if ($resultQuery->num_rows == 0) {

            $data['dataId'] = null;
            $data['nip'] = null;
            $data['status_emp'] = null;
            $data['status_name'] = null;
            $data['lokasi'] = null;
            $data['nama'] = null;
            $data['comp_id'] = null;
            $data['company_name'] = null;
            $data['tgl_masuk'] = null;
            $data['tgl_kartap'] = null;
            $data['email_kantor'] = null;
            $data['pangkat'] = null;
            $data['jabatan'] = null;
            $data['bpjstk'] = null;
            $data['bpjskes'] = null;
            $data['dept_id'] = null;
            $data['dept_name'] = null;
            $data['is_resigned'] = null;

            return $data;
        } else {
            $fetchQuery = $resultQuery->fetch_object();

            $data['dataId'] = base64_encode($fetchQuery->id_employee);
            // $data['employee'] = $fetchQuery->id_employee;
            $data['nip'] = $fetchQuery->nip;
            $data['status_emp'] = $fetchQuery->status_emp;
            $data['status_name'] = $fetchQuery->status_name;
            $data['lokasi'] = $fetchQuery->lokasi;
            $data['nama'] = $fetchQuery->nama;
            $data['comp_id'] = $fetchQuery->comp_id;
            $data['company_name'] = $fetchQuery->company_name;
            $data['tgl_masuk'] = $fetchQuery->tgl_masuk;
            $data['tgl_kartap'] = $fetchQuery->tgl_kartap;
            $data['email_kantor'] = $fetchQuery->email_kantor;
            $data['pangkat'] = $fetchQuery->pangkat;
            $data['jabatan'] = $fetchQuery->jabatan;
            $data['bpjstk'] = $fetchQuery->bpjstk;
            $data['bpjskes'] = $fetchQuery->bpjskes;
            $data['dept_id'] = $fetchQuery->dept_id;
            $data['dept_name'] = $fetchQuery->dept_name;
            $data['is_resigned'] = $fetchQuery->is_resigned;

            return $data;
        }
    }

    public function update($request)
    {
        $id = $request['id_employee'];
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

        $sql = "UPDATE employee SET nip='$nip',
        status_emp=$status_emp, lokasi='$lokasi', nama='$nama',
        comp_id=$comp_id, tgl_masuk='$tgl_masuk', email_kantor='$email_kantor',
        pangkat='$pangkat', jabatan='$jabatan', bpjstk='$bpjstk', 
        bpjskes='$bpjskes', dept_id=$dept_id, is_resigned=$is_resigned 
        WHERE id_employee=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }

    public function resigned($request)
    {
        $id = base64_decode($request['idData']);
        $id2 = base64_decode($id);
        $is_resigned = $request['is_resigned'];

        $sql = "UPDATE employee SET is_resigned=$is_resigned WHERE id_employee=$id2";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        $resultQuery = $this->resignedLog($request);
        return $resultQuery;
    }

    public function resignedLog($request)
    {
        $id = base64_decode($request['idData']);
        $emp_id = base64_decode($id);
        $tgl_pengajuan = $request['tgl_pengajuan'];
        $tgl_resign = $request['tgl_resign'] ? $request['tgl_resign'] : null;
        $alasan_resign = $request['alasan_resign'];

        if ($tgl_resign != null) {
            $sql = "INSERT INTO resigned(emp_id, tgl_pengajuan, tgl_resign, alasan_resign)
        VALUES($emp_id, '$tgl_pengajuan', '$tgl_resign', '$alasan_resign')";
        } else {
            $sql = "INSERT INTO resigned(emp_id, tgl_pengajuan, alasan_resign)
            VALUES($emp_id, '$tgl_pengajuan', '$alasan_resign')";
        }

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }

    // fungsi menampilkan data karyawan resign
    public function getDataEmployeeResigned($request)
    {
        $url = $this->home->homeurl();

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_employee) AS counts FROM employee WHERE is_resigned='1'";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_employee, nip, nama, status_name FROM employee JOIN status_emp ON employee.status_emp=status_emp.id_status WHERE is_resigned='1' AND nama LIKE '%$search%' OR nip LIKE '%$search%' ORDER BY id_employee ASC LIMIT $limit OFFSET $offset ";
            $resulData = $mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_employee) AS counts FROM employee JOIN status_emp ON employee.status_emp=status_emp.id_status WHERE is_resigned='1'AND  nama LIKE '%$search%' OR nip LIKE '%$search%' ORDER BY id_employee ASC LIMIT $limit OFFSET $offset";
            $resulCountData = $mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_employee, nip, nama, status_name FROM employee JOIN status_emp ON employee.status_emp=status_emp.id_status WHERE is_resigned='1' ORDER BY id_employee ASC LIMIT $limit OFFSET $offset";
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
            $data['index'] = base64_encode($id);
            $data['nip'] = $row->nip;
            $data['name'] = $row->nama;
            $data['status'] = "Resigned-" . $row->status_name;
            $data['action'] = "<div class='d-flex'><a href='$url/view/pages/employee/view-employee.php?dataId=$id' class='text-decoration-none align-middle' title='edit'><i class='bi bi-eye-fill'></i></a>
            <button type='button' class='btnView btn ms-2 btn-sm btn-outline-success'><i class='bi bi-box-arrow-right'></i></button></div>";
            $arr[] = $data;
            $i++;
        }

        $response['draw'] = $draw;
        $response['recordsTotal'] = $totalData;
        $response['recordsFiltered'] = $totalFiltered;
        $response['data'] = $arr;

        return $response;
    }

    public function showDataResign($request)
    {
        $id1 = base64_decode($request['id']);
        $id2 = base64_decode($id1);

        $sql = "SELECT * FROM resigned WHERE emp_id=$id2";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);
        $fetchQuery = $resultQuery->fetch_object();

        if (!$resultQuery) {
            $sukses = false;
        } else {
            $sukses = true;
        }
        $data['success'] = $sukses;
        $data['index'] = base64_encode($fetchQuery->id_resigned);
        $data['tanggal_pengajuan'] = $fetchQuery->tgl_pengajuan;
        $data['tanggal_resign'] = $fetchQuery->tgl_resign;
        $data['alasan_resign'] = $fetchQuery->alasan_resign;

        return $data;
    }

    public function employeeDetail($id)
    {
        $sql = "SELECT nama FROM employee WHERE id_employee=$id";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);
        $fetchQuery = $resultQuery->fetch_object();

        $data['nama'] = $fetchQuery->nama;
        return $data;
    }

    // fungsi ambil data mutasi karyawan
    public function getKaryawanMutasi($request)
    {
        $id = base64_decode($request['karyawan']);

        $sql = "SELECT id_employee, nama, tgl_masuk,jabatan, comp_id, company_name, dept_id, dept_name FROM
        employee JOIN company ON employee.comp_id=company.IdCompany JOIN department ON employee.dept_id=department.id_dept WHERE id_employee=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);
        $fetchQuery = $resultQuery->fetch_object();
        if ($fetchQuery) {
            $data['nama'] = $fetchQuery->nama;
            $data['tgl_masuk'] = $fetchQuery->tgl_masuk;
            $data['jabatan'] = $fetchQuery->jabatan;
            $data['company'] = $fetchQuery->comp_id;
            $data['company_name'] = $fetchQuery->company_name;
            $data['dept'] = $fetchQuery->dept_id;
            $data['dept_name'] = $fetchQuery->dept_name;
        } else {
            return null;
        }
        return $data;
    }

    // fungsi simpan data history dan update data karyawan
    public function saveHistory($request)
    {
        $id = base64_decode($request['emp_id']);
        $comp = $request['comp_lama'];
        $in = $request['periode_masuk'];
        $out = $request['periode_keluar'];
        $jabatan = $request['jabatan'];
        $paramCbx = $request['cbxVal'];
        $perubahanStatus = $request['perubahan_status'];
        $keterangan = $request['keterangan'];

        if ($this->mutasi == $paramCbx) {
            // proses mutasi karyawan
            $retunValue = $this->updateMutasiKaryawan($request);
        }
        if ($this->rotasi == $paramCbx) {
            // proses rotasi karyawan
            $retunValue = $this->updateRotasiKaryawan($request);
        }
        if ($this->promosi == $paramCbx) {
            // proses promosi karyawan
            $retunValue = $this->updatePromosiKaryawan($request);
        }
        if ($this->demosi == $paramCbx) {
            // proses demosi karyawan
            $retunValue = $this->updateDemosiKaryawan($request);
        }

        if (!$retunValue) {
            return false;
        } else {
            // fungsi simpan history karyawan
            $sql = "INSERT INTO employee_history(emp_id, comp_id, jabatan_terakhir, periode_masuk, periode_keluar, perubahan_status, keterangan, is_mutasi)
            VALUES($id, $comp, '$jabatan', '$in', '$out', '$perubahanStatus', '$keterangan', '$paramCbx')";

            $mysqli = $this->db->connect();
            $resultQuery = $mysqli->query($sql);


            $data['success'] = $resultQuery;
            $data['karyawan'] = base64_encode($id);
            return $data;
        }
    }

    // fungsi update data mutasi karyawan
    private function updateMutasiKaryawan($request)
    {
        $id = base64_decode($request['emp_id']);
        $deptNew = $request['dept_baru'];
        $jabatanNew = $request['jabatan_baru'];
        $companyNew = $request['comp_baru'];
        $tglKeluar = $request['periode_keluar'];
        $tglMasukNew = date('Y-m-d', strtotime($tglKeluar . "+1 days"));

        $sqlUpadteMutasi = "UPDATE employee SET 
        comp_id=$companyNew, tgl_masuk='$tglMasukNew', jabatan='$jabatanNew', dept_id=$deptNew
        WHERE id_employee=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlUpadteMutasi);
        return $resultQuery;
    }

    // fungsi update data rotasi karyawan
    private function updateRotasiKaryawan($request)
    {
        $id = base64_decode($request['emp_id']);
        $deptNew = $request['dept_baru'];
        $jabatanNew = $request['jabatan_baru'];

        $sqlUpadteRotasi = "UPDATE employee SET 
        jabatan='$jabatanNew', dept_id=$deptNew
        WHERE id_employee=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlUpadteRotasi);
        return $resultQuery;
    }

    // fungsi update data promosi karyawan
    private function updatePromosiKaryawan($request)
    {
        $id = base64_decode($request['emp_id']);
        $jabatanNew = $request['jabatan_baru'];
        $deptNew = $request['dept_baru'];

        $sqlUpadteRotasi = "UPDATE employee SET 
        jabatan='$jabatanNew', dept_id=$deptNew
        WHERE id_employee=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlUpadteRotasi);
        return $resultQuery;
    }
    // fungsi update data demosi karyawan
    private function updateDemosiKaryawan($request)
    {
        $id = base64_decode($request['emp_id']);
        $jabatanNew = $request['jabatan_baru'];
        $deptNew = $request['dept_baru'];

        $sqlUpadteRotasi = "UPDATE employee SET 
        jabatan='$jabatanNew', dept_id=$deptNew
        WHERE id_employee=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlUpadteRotasi);
        return $resultQuery;
    }

    // fungsi update karyawan
    // private function updateWithHistory($request)
    // {
    //     $id = base64_decode($request['emp_id']);
    //     $comp = $request['comp_baru'];
    //     $dateEnd = $request['periode_keluar'];
    //     $jabatanBaru = $request['jabatan_baru'];

    //     $dateNew = date('Y-m-d', strtotime($dateEnd . "+1 days"));

    //     $sql = "UPDATE employee SET comp_id=$comp, tgl_masuk='$dateNew', jabatan='$jabatanBaru' WHERE id_employee=$id";
    //     $mysqli = $this->db->connect();
    //     $resultQuery = $mysqli->query($sql);
    //     return $resultQuery;
    // }

    // fungsi untuk menampilkan data di tabel history
    public function showMutasi($request)
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $id = base64_decode($request['karyawan']);

        $sqlcountTotalData = "SELECT COUNT(id_history) AS counts FROM employee_history WHERE emp_id=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;


        $sqlData = "SELECT id_history, comp_id, company_name, jabatan_terakhir, periode_masuk, periode_keluar, perubahan_status, keterangan, emp_id FROM employee_history JOIN company ON employee_history.comp_id=company.IdCompany  WHERE emp_id=$id LIMIT $limit OFFSET $offset";

        $mysqli = $this->db->connect();
        $resultData = $mysqli->query($sqlData);

        $response = [];
        $data = [];
        // return $fetchQuery;
        if ($resultData->num_rows == 0) {
            $data['rnum'] = "#";
            $data['company'] = "Data Kosong";
            $data['awal'] = "Data Kosong";
            $data['akhir'] = "Data Kosong";
            $data['jabatan'] = "Data Kosong";
            $data['p_status'] = "Data Kosong";
            $data['ket'] = "Data Kosong";
            $arr[] = $data;
        } else {

            while ($row = $resultData->fetch_object()) {
                $data['rnum'] = $i;
                $data['company'] = $row->company_name ? $row->company_name : "Data Kosong";
                $data['awal'] = $row->periode_masuk ? date('d-m-Y', strtotime($row->periode_masuk)) : "Data Kosong";
                $data['akhir'] = $row->periode_keluar ? date('d-m-Y', strtotime($row->periode_keluar)) : "Data Kosong";
                $data['jabatan'] = $row->jabatan_terakhir ? $row->jabatan_terakhir  : "Data Kosong";
                $data['p_status'] = $row->perubahan_status ? $row->perubahan_status  : "Data Kosong";
                $data['ket'] = $row->keterangan ? $row->keterangan  : "Data Kosong";

                $i++;
                $arr[] = $data;
            }
        }

        $response['draw'] = $draw;
        $response['recordsTotal'] = $totalData;
        $response['recordsFiltered'] = $totalFiltered;
        $response['data'] = $arr;

        return $response;
    }
}
