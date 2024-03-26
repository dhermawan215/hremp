<?php


namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
require_once 'DepartmentController.php';
require_once 'CostCenterController.php';
require_once 'CostCenterDepartmentController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;
use App\Controller\CostCenterController;
use App\Controller\CostCenterDepartmentController;

class AllowanceController
{
    protected $db;
    private static $mysqli;
    private static $user;
    public $homeUrl;
    private $costCenter;
    private $costCenterDept;
    /** 
     * constanta approval value and status approval
     */
    protected const pending = 0;
    protected const pendingValue = '<i class="bi bi-clock text-primary"></i>';
    protected const requested = 1;
    protected const requestedValue = '<i class="bi bi-send text-primary" aria-hidden="true"></i>';
    protected const approve = 2;
    protected const approveValue = '<i class="bi bi-check-square text-success" aria-hidden="true"></i>';
    protected const rejected = 3;
    protected const rejectedValue = '<i class="bi bi-x-circle text-danger" aria-hidden="true"></i>';
    protected const revision = 4;
    protected const revisionValue = '<i class="bi bi-arrow-repeat text-warning" aria-hidden="true"></i>';


    public function __construct()
    {
        session_start();
        $this->db = new Databases;
        static::$mysqli = $this->db->connect();
        $this->homeUrl = new UriController;
        $this->costCenter = new CostCenterController;
        $this->costCenterDept = new CostCenterDepartmentController;
        static::$user = $_SESSION['user'];
    }

    /** 
     * function getDetailAllowance
     * @method  untuk mendapatkan daetail allowance
     * @return array
     */
    public static function getDetailAllowance($nomer)
    {
        $sqlmax = "SELECT id_allowance AS allowance, nomer, users_id, transaction_date, nama, period,
        hr_approve, hr_notes, manager_approve, manager_note, users.name, company.company_name, cost_center.cost_center_name, department.dept_name 
            FROM allowance LEFT JOIN users ON allowance.users_id = users.id_users
            LEFT JOIN company ON allowance.company_id = company.IdCompany
            LEFT JOIN cost_center ON allowance.cost_center_id = cost_center.id_cost_center
            LEFT JOIN department ON allowance.department_id = department.id_dept
            WHERE allowance.nomer = '$nomer'";
        $querydb = static::$mysqli->query($sqlmax);
        $fetch = $querydb->fetch_object();
        switch ($fetch->hr_approve) {
            case self::requested:
                $statusApproveHr = 'Requested';
                break;
            case self::approve:
                $statusApproveHr = 'Approved';
                break;
            case self::rejected:
                $statusApproveHr = 'Rejected';
                break;
            case self::revision:
                $statusApproveHr = 'Revision';
                break;
            default:
                $statusApproveHr = 'Pending';
                break;
        }
        switch ($fetch->manager_approve) {
            case self::requested:
                $managerStatusApprove = 'Requested';
                break;
            case self::approve:
                $managerStatusApprove = 'Approved';
                break;
            case self::rejected:
                $managerStatusApprove = 'Rejected';
                break;
            case self::revision:
                $managerStatusApprove = 'Revision';
                break;
            default:
                $managerStatusApprove = 'Pending';
                break;
        }
        $data = [
            'allowance' => $fetch->allowance,
            'nomer' => $fetch->nomer,
            'user' => $fetch->users_id,
            'user_name' => $fetch->name,
            'transaction_date' => $fetch->transaction_date,
            'subject' => $fetch->nama,
            'period' => $fetch->period,
            'hr_approve' => $fetch->hr_approve,
            'manager_approve' => $fetch->manager_approve,
            'company_name' => $fetch->company_name,
            'cost_center_name' => $fetch->cost_center_name,
            'dept_name' => $fetch->dept_name,
            'hr_status' => $statusApproveHr,
            'hr_note' => $fetch->hr_notes,
            'hr_manager_status' => $managerStatusApprove,
            'hr_manager_note' => $fetch->manager_note,
        ];

        return $data;
    }
    /** 
     * @method  untuk mendapatkan id allowance
     * @return object
     */
    public static function getIdAllowance($nomer)
    {
        $sql = "SELECT id_allowance, hr_approve, manager_approve FROM allowance WHERE nomer='$nomer' LIMIT 1";
        $querydb = static::$mysqli->query($sql);
        return $querydb->fetch_object();
    }

    /** 
     * function getNomerAllowance
     * @method  untuk mendapatkan nilai tertinggi dari nomer request allowance
     * dan akan digunakan untuk next request
     * return json (untuk request ajax)
     */
    public static function getNomerAllowance()
    {
        try {
            //begin transaction
            static::$mysqli->begin_transaction();

            $sqlmax = "SELECT nomer, MAX(id_allowance) as kode FROM allowance GROUP BY nomer, id_allowance ORDER BY id_allowance DESC LIMIT 1";
            $querydb = static::$mysqli->query($sqlmax);
            // commit transaction
            static::$mysqli->commit();
            $fetch = $querydb->fetch_object();
            $idMaxAllowance = $fetch->kode;
            $nomerAllowance = $fetch->nomer;

            $bulanTgl = date('md');
            $huruf = "ARF-";
            //konstanta urutan no 
            // ARF-022700001 
            $urutan = (int) substr($nomerAllowance, 8, 5);
            $urutan++;
            $nomerAllowanceToJson = $huruf . $bulanTgl . sprintf("%05s", $urutan);
            return $data = ['newAllowanceNo' => $nomerAllowanceToJson];
        } catch (\Throwable $th) {
            static::$mysqli->rollback();
            return \null;
        }
    }

    /**
     * function save
     * @method untuk simpan data allowance request
     * @return bool
     */
    public function save($request)
    {
        $data = [];
        $timestamp = \date('Y-m-d H:i:s');
        $userId = $request['users'];
        $no = $request['nomer'];
        $nama = $request['nama'];
        $departemen = $request['department'];
        $costCenter = \base64_decode($request['cost_center']);
        $transactionDate = $request['transaction_date'];
        $period = $request['period'];
        $company = $request['company'];
        $hr_approve = 0;
        $manager_approve = 0;

        try {
            //begin transaction
            static::$mysqli->begin_transaction();

            $sql = "INSERT INTO allowance(users_id, nomer, transaction_date, nama, company_id, cost_center_id, department_id, period, created_at, updated_at)
            VALUES($userId, '$no','$transactionDate', '$nama',
            $company, $costCenter, $departemen, '$period','$timestamp','$timestamp')";

            $query = static::$mysqli->query($sql);
            $lastInsertId = static::$mysqli->insert_id;
            $dataInsert = self::lastInsertId($lastInsertId);
            // commit transaction
            static::$mysqli->commit();
            $data['success'] = \true;
            $data['content'] = $dataInsert->nomer;
            return $data;
        } catch (\Throwable $th) {
            static::$mysqli->rollback();
            $data['success'] = \false;
            $data['content'] = \null;
            return $data;
        }
    }

    /** 
     * function lastInsertId
     * @method untuk mengambil nilai terbaru setelah dinput digunakan untuk parameter di detail request allowance
     * return object (id_allowance dan nomer)
     */
    private static function lastInsertId($id)
    {
        $sql = "SELECT id_allowance, nomer FROM allowance WHERE id_allowance=$id";
        $querydb = static::$mysqli->query($sql);
        $fetch = $querydb->fetch_object();
        return $fetch;
    }

    /**
     * function edit
     * @method untuk mengambil data allowance request
     */
    public function edit($nomer)
    {
        $sql = "SELECT id_allowance,nomer,transaction_date,nama AS subject,allowance.company_id,allowance.cost_center_id,allowance.department_id, period,
        company.company_name,cost_center.cost_center_name,department.dept_name FROM allowance
        JOIN company ON allowance.company_id=company.IdCompany
        JOIN cost_center ON allowance.cost_center_id=cost_center.id_cost_center
        JOIN department ON allowance.department_id=department.id_dept WHERE allowance.nomer='$nomer' LIMIT 1";

        $querydb = static::$mysqli->query($sql);
        $fetch = $querydb->fetch_object();

        $data = [
            'allowance' => \base64_encode($fetch->id_allowance),
            'nomer' => $fetch->nomer,
            'transaction_date' => $fetch->transaction_date,
            'subject' => $fetch->subject,
            'period' => $fetch->period,
            'company' => $fetch->company_id,
            'company_name' => $fetch->company_name,
            'cost_center' => \base64_encode($fetch->cost_center_id),
            'cost_center_name' => $fetch->cost_center_name,
            'dept' => $fetch->department_id,
            'dept_name' => $fetch->dept_name,
        ];

        return $data;
    }
    /**
     * function update
     * @method untuk update data request allowance
     */
    public function update($request)
    {
        $timestamp = \date('Y-m-d H:i:s');
        $userId = $request['users'];
        $id = \base64_decode($request['formValue']);
        // $no = $request['nomer'];
        $nama = $request['nama'];
        $departemen = $request['department'];
        $costCenter = \base64_decode($request['cost_center']);
        $transactionDate = $request['transaction_date'];
        $period = $request['period'];
        $company = $request['company'];

        $sql = "UPDATE allowance SET transaction_date='$transactionDate', nama='$nama', 
        company_id=$company, cost_center_id=$costCenter, department_id=$departemen, period='$period',
        updated_at='$timestamp' WHERE id_allowance=$id";
        $query = static::$mysqli->query($sql);

        return $query;
    }

    /**
     * function delete
     * @method hapus data allowance request
     */
    public function delete($request)
    {
        $ids = $request['ids'];
        // delete data allowance
        $idsToString = \implode(",", $ids);
        $sql = "DELETE FROM allowance WHERE id_allowance IN ($idsToString)";
        $queryAllowance = static::$mysqli->query($sql);

        // // delete data allowance detail
        if ($queryAllowance) {
            $sql = "DELETE FROM allowance_detail WHERE allowance_id IN ($idsToString)";
            $queryDetail = static::$mysqli->query($sql);
        }
        // delete data allowance file 
        // cek file jika ada
        $sqlSelectFile = "SELECT * FROM allowance_file WHERE allowance_id IN ($idsToString)";
        $querySelectFile = static::$mysqli->query($sqlSelectFile);
        $pathFileServer = '../../public/allowance/file/';
        while ($row = $querySelectFile->fetch_object()) {

            if (!file_exists($pathFileServer . $row->path)) {
                $deleteFile = '404';
            }
            //delete file dari server, berdasarkan jumlah file yg di miliki
            $deleteFile = \unlink($pathFileServer . $row->path);
        }
        // jika unlink $deleteFile true/404, maka jalankan perintah delete
        if ($deleteFile || $deleteFile = '404') {
            $sqlDelete = "DELETE FROM allowance_file WHERE allowance_id IN ($idsToString)";
            $queryDeleteAttachment = static::$mysqli->query($sqlDelete);
        }

        // return value
        if ($queryAllowance && $queryDetail) {
            $data['status'] = \true;
            $data['message'] = 'Delete success!';
            return $data;
        } else {
            if (!$queryAllowance) {
                $data['message'] = 'Delete allowance failed!';
            } else if (!$queryDetail) {
                $data['message'] = 'Delete allowance detail failed!';
            } else if (!$queryDeleteAttachment) {
                $data['message'] = 'Delete allowance file failed!';
            }
            $data['status'] = \false;
            return $data;
        }
    }
    /** 
     * function myAllowance Request
     * @method diguanakan untuk menampilkan data di tabel halaman view my request
     * @return array json (ajax data table)
     */
    public function myAllowanceRequest($request)
    {
        $url = $this->homeUrl->homeurl();
        $userLogin = static::$user['idusers'];
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_allowance) AS counts FROM allowance WHERE users_id=$userLogin";
        $resultQuery = static::$mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_allowance, nomer, nama, company.company_name, transaction_date, period, total, hr_approve, manager_approve, hr_notes, manager_note FROM allowance
            JOIN company ON allowance.company_id=company.IdCompany WHERE allowance.users_id=$userLogin AND (nama LIKE '%$search%' OR nomer LIKE '%$search%') ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_allowance) AS counts FROM allowance JOIN company ON allowance.company_id=company.IdCompany WHERE allowance.users_id=$userLogin AND (nama LIKE '%$search%' OR nomer LIKE '%$search%') ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_allowance, nomer, nama, company.company_name, transaction_date, period, total, hr_approve, manager_approve, hr_notes, manager_note FROM allowance JOIN company ON allowance.company_id=company.IdCompany WHERE allowance.users_id=$userLogin ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);
        }

        $response = [];
        $arr = [];

        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id_allowance);
            switch ($row->hr_approve) {
                case self::requested:
                    $statusApproveHr = self::requestedValue;
                    break;
                case self::approve:
                    $statusApproveHr = self::approveValue;
                    break;
                case self::rejected:
                    $statusApproveHr = self::rejectedValue;
                    break;
                case self::revision:
                    $statusApproveHr = self::revisionValue;
                    break;
                default:
                    $statusApproveHr = self::pendingValue;
                    break;
            }

            switch ($row->manager_approve) {
                case self::requested:
                    $statusApproveManager = self::requestedValue;
                    break;
                case self::approve:
                    $statusApproveManager = self::approveValue;
                    break;
                case self::rejected:
                    $statusApproveManager = self::rejectedValue;
                    break;
                case self::revision:
                    $statusApproveManager = self::revisionValue;
                    break;
                default:
                    $statusApproveManager = self::pendingValue;
                    break;
            }
            // jika hr requested dan manager pending
            if ($row->hr_approve == self::requested && $row->manager_approve == self::pending) {
                $cbx = '';
            }
            // jika hr approve dan manager request 
            else if ($row->hr_approve == self::approve && $row->manager_approve == self::requested) {
                $cbx = '';
            }
            // jika hr approve dan manager approve
            else if ($row->hr_approve == self::approve && $row->manager_approve == self::approve) {
                $cbx = '';
            } else {
                $cbx = '<input type="checkbox" class="data-menu-cbox" value="' . $row->id_allowance . '">';
            }
            $data['cbox'] = $cbx;
            $data['rnum'] = $i;
            $data['nomer'] = $row->nomer;
            $data['name'] = $row->nama;
            $data['company'] = $row->company_name;
            $data['tr_date'] = $row->transaction_date;
            $data['period'] = $row->period;
            $data['total'] = 'Rp. ' . \number_format($row->total, 0, ',', '.');
            $data['hr'] = '<a class="hr-status-info"  data-bs-toggle="modal" data-bs-target="#modal-hr-status">' . $statusApproveHr . '</a>';
            $data['manager'] = '<a class="manager-status-info"  data-bs-toggle="modal" data-bs-target="#modal-hr-status">' . $statusApproveManager . '</a>';
            $data['hr_note'] = $row->hr_notes;
            $data['manager_note'] = $row->manager_note;
            // jika hr requested dan manager pending
            if ($row->hr_approve == self::requested && $row->manager_approve == self::pending) {
                $btnEdit = '';
            } else if ($row->hr_approve == self::approve && $row->manager_approve == self::requested) {
                $btnEdit = '';
            } else if ($row->hr_approve == self::approve && $row->manager_approve == self::approve) {
                $btnEdit = '';
            } else {
                $btnEdit = '<a href="' . $url . '/view/flexy-allowance/allowance-edit.php?edit=' . $row->nomer . '" id="#btn-edit" class="btn btn-sm btn-primary btn-edit" title="edit"><i class="bi bi-pencil-square"></i></a>';
            }

            $btnPrint = '<a href="' . $url . '/view/flexy-allowance/allowance-print2.php?print=' . $row->nomer . '" id="#btn-print" class="btn btn-sm btn-primary ms-1 btn-print" title="print" target="_blank"><i class="bi bi-printer"></i> </a>';
            $btnDetail = '<a href="' . $url . '/view/flexy-allowance/allowance-detail.php?detail=' . $row->nomer . '" id="#btn-detail" class="btn btn-sm btn-success ms-1 btn-detail" title="detail allowance request"><i class="bi bi-eye"></i></a>';
            $data['action'] = '<div class="d-flex">' . $btnEdit . ' ' . $btnDetail . ' ' . $btnPrint . '</div>';
            $arr[] = $data;
            $i++;
        }

        $response['draw'] = $draw;
        $response['recordsTotal'] = $totalData;
        $response['recordsFiltered'] = $totalFiltered;
        $response['data'] = $arr;
        return $response;
    }
    /** 
     * function dropdown cost center
     * @method untuk mendapatkan data cost center berdasarkan company yg dipilih
     * @return array json (ajax data table)
     */
    public function dropdownCostCenter($request)
    {
        $costCenterDropdown = $this->costCenter->getCostCenterDropdown($request['company']);
        return $costCenterDropdown;
    }
    /** 
     * function dropdown cost center
     * @method untuk mendapatkan data cost center berdasarkan company yg dipilih
     * @return array json (ajax data table)
     */
    public function dropdownCostCenterDepartment($request)
    {
        $costCenterDeptDropdown = $this->costCenterDept->getCostDepartmentDropdown(\base64_decode($request['costcenter']));
        return $costCenterDeptDropdown;
    }
    /**
     * @method untuk membuat token setelah data total di update
     * atau saat allowance diajukan
     */
    function generateToken($id, $length = 16)
    {
        // Menghasilkan sebuah string acak
        $randomString = bin2hex(random_bytes($length));

        // Menggabungkan ID dan string acak
        $token = base64_encode($id) . ',' . $randomString;

        return $token;
    }

    function decodeToken($token)
    {
        // Memisahkan token menjadi ID dan string acak
        $parts = explode(',', $token);

        // Mengambil ID dari bagian pertama array hasil pemisahan
        $id = base64_decode($parts[0]);

        // Mengembalikan ID
        return $id;
    }

    /**
     * @method untuk print
     */
    public function printAllowance($nomer)
    {
        $allowance = static::getIdAllowance($nomer);
        $sqlmax = "SELECT id_allowance AS allowance, nomer, users_id, transaction_date, nama, period, total,
        hr_approve, hr_check_by, manager_approve_by, hr_notes, manager_approve, manager_note, users.name, company.company_name, cost_center.cost_center_name, department.dept_name 
            FROM allowance LEFT JOIN users ON allowance.users_id = users.id_users
            LEFT JOIN company ON allowance.company_id = company.IdCompany
            LEFT JOIN cost_center ON allowance.cost_center_id = cost_center.id_cost_center
            LEFT JOIN department ON allowance.department_id = department.id_dept
            WHERE allowance.nomer = '$nomer'";
        $querydb = static::$mysqli->query($sqlmax);
        $fetch = $querydb->fetch_object();
        switch ($fetch->hr_approve) {
            case self::requested:
                $statusApproveHr = 'Requested';
                break;
            case self::approve:
                $statusApproveHr = 'Approved';
                break;
            case self::rejected:
                $statusApproveHr = 'Rejected';
                break;
            case self::revision:
                $statusApproveHr = 'Revision';
                break;
            default:
                $statusApproveHr = 'Pending';
                break;
        }
        switch ($fetch->manager_approve) {
            case self::requested:
                $managerStatusApprove = 'Requested';
                break;
            case self::approve:
                $managerStatusApprove = 'Approved';
                break;
            case self::rejected:
                $managerStatusApprove = 'Rejected';
                break;
            case self::revision:
                $managerStatusApprove = 'Revision';
                break;
            default:
                $managerStatusApprove = 'Pending';
                break;
        }
        $response = [];
        $data = [
            'nomer' => $fetch->nomer,
            'user' => $fetch->users_id,
            'user_name' => $fetch->name,
            'transaction_date' => $fetch->transaction_date,
            'subject' => $fetch->nama,
            'period' => $fetch->period,
            'hr_approve' => $fetch->hr_approve,
            'manager_approve' => $fetch->manager_approve,
            'company_name' => $fetch->company_name,
            'cost_center_name' => $fetch->cost_center_name,
            'dept_name' => $fetch->dept_name,
            'hr_status' => $statusApproveHr,
            'hr_note' => $fetch->hr_notes,
            'hr_manager_status' => $managerStatusApprove,
            'hr_manager_note' => $fetch->manager_note,
            'total' => 'Rp. ' . \number_format($fetch->total, 0, ',', '.'),
            'hr_check_by' => $fetch->hr_check_by,
            'manager_approve_by' => $fetch->manager_approve_by,
        ];

        $sqlSum = "SELECT SUM(jumlah_biaya_klaim) AS total_claim_amount FROM allowance_detail
        JOIN aktivitas ON allowance_detail.aktivitas_id=aktivitas.id_aktivitas JOIN aktivitas_detail ON allowance_detail.aktivitas_detail_id=aktivitas_detail.id_aktivitas_detail WHERE allowance_id=$allowance->id_allowance";
        $querySum = static::$mysqli->query($sqlSum);
        $fetchSum = $querySum->fetch_object();

        $totalClaimAmount = (int)$fetchSum->total_claim_amount;

        $sqlSearch = "SELECT allowance_detail.deskripsi, kategori_tertanggung, nama_tertanggung, jumlah_biaya_bon, jumlah_biaya_klaim,
        tanggal_aktivitas, aktivitas.nama AS activity, aktivitas_detail.nama_detail 
        FROM allowance_detail JOIN aktivitas ON allowance_detail.aktivitas_id=aktivitas.id_aktivitas 
        JOIN aktivitas_detail ON allowance_detail.aktivitas_detail_id=aktivitas_detail.id_aktivitas_detail
         WHERE allowance_detail.allowance_id=$allowance->id_allowance";
        $resultItemDetail = static::$mysqli->query($sqlSearch);
        $no = 1;


        while ($rowDetail = $resultItemDetail->fetch_object()) {
            switch ($rowDetail->kategori_tertanggung) {
                case 'nama_suami_istri':
                    $dependents = 'Husband/Wife';
                    break;

                case 'anak1':
                    $dependents = '1st Child';
                    break;

                case 'anak1':
                    $dependents = '2nd Child';
                    break;

                case 'anak3':
                    $dependents = '3rd Child';
                    break;

                default:
                    $dependents = 'Your self';
                    break;
            }
            $arr[] = '
            <tr>
                <td>' . $no . '</td>
                <td>' . $rowDetail->activity . '</td>
                <td>' . $rowDetail->nama_detail . '</td>
                <td>' . $rowDetail->deskripsi . '</td>
                <td>' . $dependents . '</td>
                <td>' . $rowDetail->nama_tertanggung . '</td>
                <td>Rp. ' . \number_format($rowDetail->jumlah_biaya_bon, 0, ',', '.') . '</td>
                <td>Rp. ' . \number_format($rowDetail->jumlah_biaya_klaim, 0, ',', '.') . '</td>
                <td>' . $rowDetail->tanggal_aktivitas . '</td>
            </tr>';
            $no++;
        }
        $response['detail'] = $data;
        $response['item'] = $arr;
        $response['total_claim_amount'] = 'Rp. ' . \number_format($totalClaimAmount, 0, ',', '.');
        return $response;
    }

    function test()
    {
        // cut off untuk report
        // cut off
        // 25-26 perbulan
        // $dataStart = $tahun-$bulan-26;
        // $dataEnd = $tahun-$bulan-25;


    }
}
