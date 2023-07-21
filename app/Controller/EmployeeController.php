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
            $data['action'] = "<div class='d-flex'><a href='$url/view/pages/employee/view-employee.php?dataId=$id' class='text-decoration-none align-middle' title='edit'><i class='bi bi-eye-fill'></i></a><button id='btnResigned' class='btnresigned ms-2 text-danger border-0' data-id='$row->id_employee' title='resign' data-bs-toggle='modal' data-bs-target='#modalIsResigned' ><i class='bi bi-box-arrow-right'></i></button></div>";
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

        if ($tgl_resign != null) {
            $sql = "INSERT INTO resigned(emp_id, tgl_pengajuan, tgl_resign)
        VALUES($emp_id, '$tgl_pengajuan', '$tgl_resign')";
        }


        $sql = "INSERT INTO resigned(emp_id, tgl_pengajuan)
        VALUES($emp_id, '$tgl_pengajuan')";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
