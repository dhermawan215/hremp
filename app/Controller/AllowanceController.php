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
     * function update
     * @method untuk update data request allowance
     */
    public function update($request)
    {
    }

    /**
     * function delete
     * @method hapus data request
     */
    public function delete($id)
    {
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
            $sqlSearch = "SELECT id_allowance, nomer, nama, total, hr_approve, manager_approve FROM allowance  WHERE users_id=$userLogin AND (nama LIKE '%$search%' OR nomer LIKE '%$search%') ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_allowance) AS counts FROM allowance WHERE users_id=$userLogin AND (nama LIKE '%$search%' OR nomer LIKE '%$search%') ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_allowance,nomer,nama, total, hr_approve, manager_approve FROM allowance WHERE users_id=$userLogin ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
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

            $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $row->id_allowance . '">';
            $data['rnum'] = $i;
            $data['nomer'] = $row->nomer;
            $data['name'] = $row->nama;
            $data['company'] = 'PT Zeus Kimiatama Indonesi';
            $data['tr_date'] = '29-02-2024';
            $data['period'] = '2024';
            $data['total'] = 'Rp. ' . \number_format($row->total, 0, ',', '.');
            $data['hr'] = $statusApproveHr;
            $data['manager'] = $statusApproveManager;
            $data['action'] = '<div class="d-flex"><a href="#" id="#btn-edit" class="btn btn-sm btn-primary btn-edit" title="edit"><i class="bi bi-pencil-square"></i></a><a href="#" id="#btn-detail" class="btn btn-sm btn-success ms-1 btn-detail" title="detail allowance request"><i class="bi bi-eye"></i></a></div>';
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
}
