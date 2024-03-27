<?php


namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
require_once 'DepartmentController.php';
require_once 'CostCenterController.php';
require_once 'CostCenterDepartmentController.php';
require_once '../../vendor/autoload.php';
include_once '../protected.php';

date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;
use App\Controller\CostCenterController;
use App\Controller\CostCenterDepartmentController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


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
    protected const emailHost = 'mail.powerchemicals.co.id';
    protected const userName = 'flexy.app@powerchemicals.co.id';
    protected const emailPwd = 'AllowanceApp1234!';
    protected const port = 465;

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
            WHERE allowance.nomer = '$nomer';";
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

            $data['action'] = '<div class="d-flex">' . $btnEdit . '<a href="' . $url . '/view/flexy-allowance/allowance-detail.php?detail=' . $row->nomer . '" id="#btn-detail" class="btn btn-sm btn-success ms-1 btn-detail" title="detail allowance request"><i class="bi bi-eye"></i></a></div>';
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
    private static function generateToken($id, $length = 16)
    {
        // Menghasilkan sebuah string acak
        $randomString = bin2hex(random_bytes($length));

        // Menggabungkan ID dan string acak
        $token = $id . ',' . $randomString . '-' . date('is');

        return $token;
    }

    private static function decodeToken($token)
    {
        // Memisahkan token menjadi ID dan string acak
        $parts = explode(',', $token);

        // Mengambil ID dari bagian pertama array hasil pemisahan
        $id = base64_decode($parts[0]);

        // Mengembalikan ID
        return $id;
    }

    function test()
    {
        // cut off untuk report
        // cut off
        // 25-26 perbulan
        // $dataStart = $tahun-$bulan-26;
        // $dataEnd = $tahun-$bulan-25;
    }
    /**
     * @method untuk data email
     * @param no_allowance
     */
    public static function allowanceWhenSendRequest($nomer)
    {
        $sql = "SELECT id_allowance, nomer, transaction_date, nama AS subject, period, total, token, users.name, company.company_name, cost_center.cost_center_name, department.dept_name 
            FROM allowance LEFT JOIN users ON allowance.users_id = users.id_users
            LEFT JOIN company ON allowance.company_id = company.IdCompany
            LEFT JOIN cost_center ON allowance.cost_center_id = cost_center.id_cost_center
            LEFT JOIN department ON allowance.department_id = department.id_dept
            WHERE allowance.nomer = '$nomer';";
        $querydb = static::$mysqli->query($sql);
        return $querydb->fetch_object();
    }
    /**
     * @method ketika user menekan tombol pengajuan maka data total dan status hr approve
     * berubah
     * @param no_allowance
     * @param total
     */
    public static function updateTotalWhenRequest($request)
    {
        $noAllowance = $request['noAllowance'];
        $token = self::generateToken($request['noAllowance']);
        $total = $request['total'];
        $sql = "UPDATE allowance SET total=$total, hr_approve=1, token='$token' WHERE nomer='$noAllowance'";
        $query = static::$mysqli->query($sql);
        return $query;
    }
    /**
     * @method untuk user send request
     */
    public function sendRequest($request)
    {
        // update data(total, status approval hr, dan token)
        $updateWhenRequest = self::updateTotalWhenRequest($request);
        // ambil data allowance untuk body email
        $allowanceContent = self::allowanceWhenSendRequest($request['noAllowance']);
        // perpare email
        $url = $this->homeUrl->homeurl();
        $mail = new PHPMailer(true);
        $hrAdminName = 'Salsa';
        $hrAdminEmail = 'hr-test-allowance@powerchemicals.co.id';

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = self::emailHost;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = self::userName;                     //SMTP username
            $mail->Password   = self::emailPwd;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = self::port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('flexy.app@powerchemicals.co.id', 'Flexy App Mail System');
            $mail->addAddress($hrAdminEmail);      //Add a recipient

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            $urlPath = $this->homeUrl->homeurl();
            $imagePath = $urlPath . '/public/img/logo-zekindo-comp.png';
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Flexy App - Allowance No: ' . $allowanceContent->nomer . ' is requested';
            $mail->Body    = '
            <html lang="en">
                <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <title>Simple Transactional Email</title>
                    <style media="all" type="text/css">
                        /* -------------------------------------
                        GLOBAL RESETS
                        ------------------------------------- */
                    
                        body {
                        font-family: Helvetica, sans-serif;
                        -webkit-font-smoothing: antialiased;
                        font-size: 16px;
                        line-height: 1.3;
                        -ms-text-size-adjust: 100%;
                        -webkit-text-size-adjust: 100%;
                        }
                        
                        table {
                        border-collapse: separate;
                        mso-table-lspace: 0pt;
                        mso-table-rspace: 0pt;
                        width: 100%;
                        }
                        
                        table td {
                        font-family: Helvetica, sans-serif;
                        font-size: 16px;
                        vertical-align: top;
                        }
                                /* -------------------------------------
                                BODY & CONTAINER
                            ------------------------------------- */
                        
                        body {
                        background-color: #f4f5f6;
                        margin: 0;
                        padding: 0;
                        }
                    
                        .body {
                        background-color: #f4f5f6;
                        width: 100%;
                        }
                        
                        .container {
                        margin: 0 auto !important;
                        max-width: 600px;
                        padding: 0;
                        padding-top: 24px;
                        width: 600px;
                        }
                        
                        .content {
                        box-sizing: border-box;
                        display: block;
                        margin: 0 auto;
                        max-width: 600px;
                        padding: 0;
                        }
                                /* -------------------------------------
                                HEADER, FOOTER, MAIN
                            ------------------------------------- */
                        
                        .main {
                        background: #ffffff;
                        border: 1px solid #eaebed;
                        border-radius: 16px;
                        width: 100%;
                        }
                        
                        .wrapper {
                        box-sizing: border-box;
                        padding: 24px;
                        }
                        
                        .footer {
                        clear: both;
                        padding-top: 24px;
                        text-align: center;
                        width: 100%;
                        }
                        
                        .footer td,
                        .footer p,
                        .footer span,
                        .footer a {
                        color: #9a9ea6;
                        font-size: 16px;
                        text-align: center;
                        }
                                /* -------------------------------------
                                TYPOGRAPHY
                            ------------------------------------- */
                        
                        p {
                        font-family: Helvetica, sans-serif;
                        font-size: 16px;
                        font-weight: normal;
                        margin: 0;
                        margin-bottom: 16px;
                        }
                        
                        a {
                        color: #0867ec;
                        text-decoration: underline;
                        }
                                /* -------------------------------------
                                BUTTONS
                            ------------------------------------- */
                        /* Gaya dasar untuk tombol */
                        .btn {
                            display: inline-block;
                            font-weight: 400;
                            color: #212529;
                            text-align: center;
                            vertical-align: middle;
                            -webkit-user-select: none;
                            -moz-user-select: none;
                            -ms-user-select: none;
                            user-select: none;
                            background-color: transparent;
                            border: 1px solid transparent;
                            padding: 0.375rem 0.75rem;
                            font-size: 1rem;
                            line-height: 1.5;
                            border-radius: 0.25rem;
                            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                        }

                        /* Gaya tambahan untuk tombol dengan variasi warna */
                        .btn-primary {
                            color: #fff;
                            background-color: #007bff;
                            border-color: #007bff;
                            text-decoration:none;
                        }
                        .btn-primary:hover {
                            color: #fff;
                            background-color: #0056b3;
                            border-color: #0056b3;
                        }
                        .btn-primary:focus, .btn-primary.focus {
                            color: #fff;
                            background-color: #0056b3;
                            border-color: #0056b3;
                            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
                        }
                        .btn-primary.disabled, .btn-primary:disabled {
                            color: #fff;
                            background-color: #007bff;
                            border-color: #007bff;
                        }
                        
                        .btn-danger {
                            color: #fff;
                            background-color: #d61a0d;
                            border-color: #911209;
                            text-decoration:none;
                        }
                        .btn-danger:hover {
                            color: #fff;
                            background-color: #911209;
                            border-color: #d61a0d;
                        }
                        .btn-danger:focus, .btn-danger.focus {
                            color: #fff;
                            background-color: #911209;
                            border-color: #d61a0d;
                            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
                        }
                        .btn-danger.disabled, .btn-danger:disabled {
                            color: #fff;
                            background-color: #d61a0d;
                            border-color: #911209;
                        }
                        .btn-warning {
                            color: #fff;
                            background-color: #cc9808;
                            border-color: #a67b05;
                            text-decoration:none;
                        }
                        .btn-warning:hover {
                            color: #fff;
                            background-color: #a67b05;
                            border-color: #cc9808;
                        }
                        .btn-warning:focus, .btn-warning.focus {
                            color: #fff;
                            background-color: #a67b05;
                            border-color: #cc9808;
                            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
                        }
                        .btn-warning.disabled, .btn-warning:disabled {
                            color: #fff;
                            background-color: #a67b05;
                            border-color: #cc9808;
                        }

                        /* Gaya tambahan untuk tombol dengan variasi ukuran */
                        .btn-sm {
                            padding: 0.25rem 0.5rem;
                            font-size: 0.875rem;
                            line-height: 1.5;
                            border-radius: 0.2rem;
                        }
                        .btn-lg {
                            padding: 0.5rem 1rem;
                            font-size: 1.25rem;
                            line-height: 1.5;
                            border-radius: 0.3rem;
                        }
                        
                        @media all {
                        
                        }
                            
                            /* -------------------------------------
                            OTHER STYLES THAT MIGHT BE USEFUL
                        ------------------------------------- */
                        
                        .last {
                        margin-bottom: 0;
                        }
                        
                        .first {
                        margin-top: 0;
                        }
                        
                        .align-center {
                        text-align: center;
                        }
                        
                        .align-right {
                        text-align: right;
                        }
                        
                        .align-left {
                        text-align: left;
                        }
                        
                        .text-link {
                        color: #0867ec !important;
                        text-decoration: underline !important;
                        }
                        
                        .clear {
                        clear: both;
                        }
                        
                        .mt0 {
                        margin-top: 0;
                        }
                        
                        .mb0 {
                        margin-bottom: 0;
                        }
                        
                        .preheader {
                        color: transparent;
                        display: none;
                        height: 0;
                        max-height: 0;
                        max-width: 0;
                        opacity: 0;
                        overflow: hidden;
                        mso-hide: all;
                        visibility: hidden;
                        width: 0;
                        }
                        
                        .powered-by a {
                        text-decoration: none;
                        }
                        
                        /* -------------------------------------
                        RESPONSIVE AND MOBILE FRIENDLY STYLES
                        ------------------------------------- */
                            
                        @media only screen and (max-width: 640px) {
                        .main p,
                        .main td,
                        .main span {
                            font-size: 16px !important;
                        }
                        .wrapper {
                            padding: 8px !important;
                        }
                        .content {
                            padding: 0 !important;
                        }
                        .container {
                            padding: 0 !important;
                            padding-top: 8px !important;
                            width: 100% !important;
                        }
                        .main {
                            border-left-width: 0 !important;
                            border-radius: 0 !important;
                            border-right-width: 0 !important;
                        }
                        
                        
                        }
                        /* -------------------------------------
                        PRESERVE THESE STYLES IN THE HEAD
                        ------------------------------------- */
                        
                        @media all {
                            .ExternalClass {
                                width: 100%;
                            }
                            .ExternalClass,
                            .ExternalClass p,
                            .ExternalClass span,
                            .ExternalClass font,
                            .ExternalClass td,
                            .ExternalClass div {
                                line-height: 100%;
                            }
                            .apple-link a {
                                color: inherit !important;
                                font-family: inherit !important;
                                font-size: inherit !important;
                                font-weight: inherit !important;
                                line-height: inherit !important;
                                text-decoration: none !important;
                            }
                            #MessageViewBody a {
                                color: inherit;
                                text-decoration: none;
                                font-size: inherit;
                                font-family: inherit;
                                font-weight: inherit;
                                line-height: inherit;
                            }
                        }
                    </style>
                </head>
                <body>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
                    
                    <tr>
                        <td>&nbsp;</td>
                        <td class="container">
                            <div class="content">

                                <!-- START CENTERED WHITE CONTAINER -->
                                <span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="main">

                                <!-- START MAIN CONTENT AREA -->
                                <tr>
                                    
                                    <td class="wrapper">
                                    <div style="display:flex; justify-content: space-between;">
                                    <img src="' . $imagePath . '" height="50px">
                                    <h5>Flexy Allowance App</h5></div>
                                    <hr>
                                    <p>Dear ' . $hrAdminName . '</p>
                                    <p>' . $allowanceContent->name . ', submitted an allowance request with the following details:</p>
                                    <ul style="list-style-type: none; margin-left:-25px">
                                        <li>Allowance ID: ' . $allowanceContent->nomer . '</li>
                                        <li>Subject: ' . $allowanceContent->subject . '</li>
                                        <li>Total: Rp. ' . \number_format($allowanceContent->total, 0, ',', '.') . '</li>
                                        <li>Date: ' . $allowanceContent->transaction_date . '</li>
                                        <li>Company: ' . $allowanceContent->company_name . '</li>
                                        <li>Cost Center & Department: ' . $allowanceContent->cost_center_name . '-' . $allowanceContent->dept_name . '</li>
                                        <li>Period: ' . $allowanceContent->period . '</li>
                                    </ul>
                                    <div style="display:flex; justify-content:flex-start; margin-bottom:10px">
                                        <a href="' . $url . '/app/callback/hr-approve-callback.php?token=' . $allowanceContent->token . '&action=approve&check=' . $hrAdminName . '" style="margin-right:10px" class="btn btn-primary">Approve</a>
                                        <a href="' . $url . '/app/callback/hr-reject-callback.php?token=' . $allowanceContent->token . '&action=reject&check=' . $hrAdminName . '" style="margin-right:10px" class="btn btn-danger">Rejected</a>
                                        <a href="' . $url . '/app/callback/hr-revision-callback.php?token=' . $allowanceContent->token . '&action=revision&check=' . $hrAdminName . '" class="btn btn-warning">Revision</a>
                                    </div>
                                    
                                    <p>For allowance details can be seen in the link below:</p>
                                    <a href="' . $url . '/view/sign/hr-sign.php?token=' . $allowanceContent->token . '">View this request in HR Integrated system - flexy allowance app</a>
                                <p style="margin-top:15px"><strong>Cheers!</strong></p>
                                <p>The HR Team</p>
                                </tr>
                                </table>
                                <!-- START FOOTER -->
                                <div class="footer">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                    <td class="content-block">
                                        <span class="apple-link">HR Integrated System &copy; 2024</span>
                                    
                                    </td>
                                    </tr>
                                    <tr>
                                    <td class="content-block powered-by">
                                        Powered by IT Zekindo Companies
                                    </td>
                                    </tr>
                                </table>
                                </div>                        
                            </div>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    </table>
                </body>
             </html>
        ';

            $mail->send();
            $response['status'] = \true;
            $response['message'] = 'Request success to send';
            return $response;
        } catch (Exception $e) {
            $response['status'] = \false;
            $response['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return $response;
        }
    }
}
