<?php


namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';
require_once '../../vendor/autoload.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;
use Carbon\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class HrAllowanceController
{
    protected $db;
    private static $mysqli;
    private static $user;
    public $homeUrl;
    protected const emailHost = 'mail.powerchemicals.co.id';
    protected const userName = 'flexy.app@powerchemicals.co.id';
    protected const emailPwd = 'AllowanceApp1234!';
    protected const port = 465;
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
    protected static  $token;

    public function __construct()
    {
        session_start();
        $this->db = new Databases;
        static::$mysqli = $this->db->connect();
        $this->homeUrl = new UriController;
        static::$user = $_SESSION['user'];
        new Carbon;
        static::$token = bin2hex(random_bytes(12)) . '-' . \date('is');
    }

    /** 
     * function getDetailAllowance
     * @method  untuk mendapatkan daetail allowance
     * @return array
     */
    public static function getDetailAllowance($nomer)
    {
        $sqlmax = "SELECT id_allowance AS allowance, nomer, transaction_date, nama, period,
        hr_approve, hr_notes, hr_check_at, manager_approve, manager_note, users.name, company.company_name, cost_center.cost_center_name, department.dept_name 
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
        // logika button muncul
        $dataButtonId = \base64_encode($fetch->allowance);
        if ($fetch->hr_approve == self::requested) {
            $btnApprove = '<button type="button" class="btn btn-outline-primary" id="btn-approve-allowance" data-approve="' . $dataButtonId . '">Approve</button>';
            $btnRevision = ' <button type="button" class="btn btn-outline-warning" id="btn-revision-allowance" data-revision="' . $dataButtonId . '" data-bs-toggle="modal" data-bs-target="#revision-modal">Revision</button>';
            $btnRejected = '<button type="button" class="btn btn-outline-danger" id="btn-rejected-allowance" data-rejected="' . $dataButtonId . '" data-bs-toggle="modal" data-bs-target="#rejected-modal">Rejected</button>';
        } else {
            $btnApprove = '';
            $btnRevision = '';
            $btnRejected = '';
        }

        $data = [
            'nomer' => $fetch->nomer,
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
            'hr_note' => $fetch->hr_notes ? $fetch->hr_notes : 'empty data',
            'hr_check_at' => $fetch->hr_check_at ? Carbon::parse($fetch->hr_check_at)->locale('id-ID')->format('l, j F Y ; h:i:s a') : 'empty data',
            'hr_manager_status' => $managerStatusApprove,
            'hr_manager_note' => $fetch->manager_note ? $fetch->manager_note : 'empty data',
            'btn_approve' => $btnApprove,
            'btn_revision' => $btnRevision,
            'btn_rejected' => $btnRejected,
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
     * @method untuk datatable hr need check
     * @return array json (ajax data table)
     */
    public function hrNeedCheckList($request)
    {
        $url = $this->homeUrl->homeurl();
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_allowance) AS counts FROM allowance WHERE hr_approve='1'";
        $resultQuery = static::$mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_allowance, nomer, nama, company.company_name, transaction_date, period, total, hr_approve, manager_approve, users.name as requestor FROM allowance
            JOIN company ON allowance.company_id=company.IdCompany JOIN users ON allowance.users_id=users.id_users
            WHERE allowance.hr_approve='1' AND (nama LIKE '%$search%' OR nomer LIKE '%$search%' OR users.name LIKE '%$search%') ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_allowance) AS counts FROM allowance JOIN company ON allowance.company_id=company.IdCompany JOIN users ON allowance.userS_id=users.id_users WHERE allowance.hr_approve='1' AND (nama LIKE '%$search%' OR nomer LIKE '%$search%' OR users.name LIKE '%$search%') ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_allowance, nomer, nama, company.company_name, transaction_date, period, total, hr_approve, manager_approve, users.name as requestor FROM allowance JOIN company ON allowance.company_id=company.IdCompany 
            JOIN users ON allowance.users_id=users.id_users WHERE allowance.hr_approve='1' ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
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

            $data['rnum'] = $i;
            $data['nomer'] = $row->nomer . ' | ' . $row->requestor;
            $data['name'] = $row->nama;
            $data['company'] = $row->company_name;
            $data['tr_date'] = $row->transaction_date;
            $data['period'] = $row->period;
            $data['total'] = 'Rp. ' . \number_format($row->total, 0, ',', '.');
            $data['hr'] = $statusApproveHr;
            $data['manager'] =  $statusApproveManager;

            $data['action'] = '<div class="d-flex"><a href="' . $url . '/view/hr-panel/allowance-detail.php?detail=' . $row->nomer . '" id="#btn-detail" class="btn btn-sm btn-success ms-1 btn-detail" title="detail allowance request"><i class="bi bi-eye"></i></a></div>';
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
     * @method untuk datatable hr approve
     * @return array json (ajax data table)
     */
    public function hrApproved($request)
    {
        $url = $this->homeUrl->homeurl();
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_allowance) AS counts FROM allowance WHERE hr_approve='2'";
        $resultQuery = static::$mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_allowance, nomer, nama, company.company_name, transaction_date, period, total, hr_approve, manager_approve, users.name as requestor FROM allowance
            JOIN company ON allowance.company_id=company.IdCompany JOIN users ON allowance.users_id=users.id_users
            WHERE allowance.hr_approve='2' AND (nama LIKE '%$search%' OR nomer LIKE '%$search%' OR users.name LIKE '%$search%') ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_allowance) AS counts FROM allowance JOIN company ON allowance.company_id=company.IdCompany JOIN users ON allowance.userS_id=users.id_users WHERE allowance.hr_approve='2' AND (nama LIKE '%$search%' OR nomer LIKE '%$search%' OR users.name LIKE '%$search%') ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_allowance, nomer, nama, company.company_name, transaction_date, period, total, hr_approve, manager_approve, users.name as requestor FROM allowance JOIN company ON allowance.company_id=company.IdCompany 
            JOIN users ON allowance.users_id=users.id_users WHERE allowance.hr_approve='2' ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
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

            $data['rnum'] = $i;
            $data['nomer'] = $row->nomer . ' | ' . $row->requestor;
            $data['name'] = $row->nama;
            $data['company'] = $row->company_name;
            $data['tr_date'] = $row->transaction_date;
            $data['period'] = $row->period;
            $data['total'] = 'Rp. ' . \number_format($row->total, 0, ',', '.');
            $data['hr'] = $statusApproveHr;
            $data['manager'] =  $statusApproveManager;

            $data['action'] = '<div class="d-flex"><a href="' . $url . '/view/hr-panel/allowance-detail.php?detail=' . $row->nomer . '" id="#btn-detail" class="btn btn-sm btn-success ms-1 btn-detail" title="detail allowance request"><i class="bi bi-eye"></i></a></div>';
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
     * @method untuk menampilkan item data tabel di detail allowance
     * @return json
     */
    public function detailItemAllowance($request)
    {
        $allowance =  static::getIdAllowance($request['nomer']);
        $idAllowance = $allowance->id_allowance;

        $url = $this->homeUrl->homeurl();
        $userLogin = static::$user['idusers'];
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_all_det) AS counts FROM allowance_detail
        JOIN aktivitas ON allowance_detail.aktivitas_id=aktivitas.id_aktivitas JOIN aktivitas_detail ON allowance_detail.aktivitas_detail_id=aktivitas_detail.id_aktivitas_detail WHERE allowance_detail.allowance_id='$idAllowance'";
        $resultQuery = static::$mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $sqlSum = "SELECT SUM(jumlah_biaya_klaim) AS total_claim_amount FROM allowance_detail
        JOIN aktivitas ON allowance_detail.aktivitas_id=aktivitas.id_aktivitas JOIN aktivitas_detail ON allowance_detail.aktivitas_detail_id=aktivitas_detail.id_aktivitas_detail WHERE allowance_id=$idAllowance";
        $querySum = static::$mysqli->query($sqlSum);
        $fetchSum = $querySum->fetch_object();

        $totalClaimAmount = (int)$fetchSum->total_claim_amount;

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_all_det, allowance_detail.deskripsi, kategori_tertanggung, nama_tertanggung, jumlah_biaya_bon, jumlah_biaya_klaim, tanggal_aktivitas, aktivitas.nama AS activity, aktivitas_detail.nama_detail FROM allowance_detail
            JOIN aktivitas ON allowance_detail.aktivitas_id=aktivitas.id_aktivitas JOIN aktivitas_detail ON allowance_detail.aktivitas_detail_id=aktivitas_detail.id_aktivitas_detail WHERE allowance_detail.allowance_id=$idAllowance AND (aktivitas.nama LIKE '%$search%' OR allowance_detail.deskripsi LIKE '%$search%') ORDER BY id_all_det ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_all_det) AS counts FROM allowance_detail
            JOIN aktivitas ON allowance_detail.aktivitas_id=aktivitas.id_aktivitas JOIN aktivitas_detail ON allowance_detail.aktivitas_detail_id=aktivitas_detail.id_aktivitas_detail WHERE allowance_detail.allowance_id=$idAllowance AND (aktivitas.nama LIKE '%$search%' OR allowance_detail.deskripsi LIKE '%$search%') ORDER BY id_all_det ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_all_det, allowance_detail.deskripsi, kategori_tertanggung, nama_tertanggung, jumlah_biaya_bon, jumlah_biaya_klaim, tanggal_aktivitas, aktivitas.nama AS activity, aktivitas_detail.nama_detail FROM allowance_detail
            JOIN aktivitas ON allowance_detail.aktivitas_id=aktivitas.id_aktivitas JOIN aktivitas_detail ON allowance_detail.aktivitas_detail_id=aktivitas_detail.id_aktivitas_detail WHERE allowance_detail.allowance_id=$idAllowance ORDER BY id_all_det ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);
        }

        $response = [];
        $arr = [];

        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id_all_det);
            $data['rnum'] = $i;
            $data['activity'] = $row->activity;
            $data['detail'] = $row->nama_detail;
            $data['desc'] = $row->deskripsi;
            switch ($row->kategori_tertanggung) {
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
            $data['dependents'] = $dependents;
            $data['insured'] = $row->nama_tertanggung;
            $data['total_amount'] = 'Rp. ' . \number_format($row->jumlah_biaya_bon, 0, ',', '.');
            $data['claim_amount'] = 'Rp. ' . \number_format($row->jumlah_biaya_klaim, 0, ',', '.');
            $data['date'] = $row->tanggal_aktivitas;
            $arr[] = $data;
            $i++;
        }

        $response['draw'] = $draw;
        $response['recordsTotal'] = $totalData;
        $response['recordsFiltered'] = $totalFiltered;
        $response['data'] = $arr;
        $response['total_claim_amount'] = $totalClaimAmount;
        return $response;
    }

    /**
     * @method untuk menampilkan dokumen data tabel di detail allowance
     * @return json
     */
    public function documentAllowance($request)
    {
        $allowance =  static::getIdAllowance($request['nomer']);
        $allowance_id = $allowance->id_allowance;
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_allowance_file) AS counts FROM allowance_file WHERE allowance_id=$allowance_id";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();
        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT * FROM allowance_file WHERE allowance_id=$allowance_id AND (document_name LIKE '%$search%') ORDER BY id_allowance_file ASC LIMIT $limit OFFSET $offset ";
            $resulData = $mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_allowance_file) AS counts FROM allowance_file WHERE allowance_id=$allowance_id AND (document_name LIKE '%$search%') ORDER BY id_allowance_file ASC LIMIT $limit OFFSET $offset";
            $resulCountData = $mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT * FROM allowance_file WHERE allowance_id=$allowance_id ORDER BY id_allowance_file ASC LIMIT $limit OFFSET $offset";
            $resulData = $mysqli->query($sqlSearch);
        }

        $response = [];
        $arr = [];
        $url = $this->homeUrl->homeurl();

        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id_allowance_file);
            $data['rnum'] = $i;
            $data['name'] = '<a href="' . $url . '/public/allowance/file/' . $row->path . '">' . $row->document_name . '</a>';
            $data['upload_time'] = Carbon::parse($row->uploaded_at)->locale('id-ID')->format('l, j F Y ; h:i:s a');
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
     * @method untuk hr approve
     * @return email/bool
     */
    public function approve($request)
    {
        $url = $this->homeUrl->homeurl();
        $nomerAllowance = $request['nomerAllowance'];
        $checkBy = 'Salsa';
        $updateTimestamp = Carbon::now();
        // update data allowance jika hr approve
        $sql = "UPDATE allowance SET hr_approve=2, hr_notes=null, hr_check_by='$checkBy', hr_check_at='$updateTimestamp', manager_approve=1, updated_at='$updateTimestamp' WHERE nomer='$nomerAllowance'";
        $query = static::$mysqli->query($sql);
        //ambil data allowance
        $data = self::contentEmail($nomerAllowance);

        $mail = new PHPMailer(true);
        $name = 'Yana Marlianty';
        $hrAdminEmail = 'manager.test@powerchemicals.co.id';

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

            $urlPath = $url;
            $imagePath = $urlPath . '/public/img/logo-zekindo-comp.png';
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Flexy App - Allowance No: ' . $data->nomer . ' is appoved by HR';
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
                                        <p>Dear ' . $name . '</p>
                                        <p>' . $data->name . ', submitted an allowance request it with the following details:</p>
                                        <ul style="list-style-type: none; margin-left:-25px">
                                            <li><b>Status: Approve/has been chek by HR Admin(' . $data->hr_check_by . ')</b></li>
                                            <li>Allowance ID: ' . $data->nomer . '</li>
                                            <li>Subject: ' . $data->subject . '</li>
                                            <li>Total: Rp. ' . \number_format($data->total, 0, ',', '.') . '</li>
                                            <li>Date: ' . $data->transaction_date . '</li>
                                            <li>Company: ' . $data->company_name . '</li>
                                            <li>Cost Center & Department: ' . $data->cost_center_name . '-' . $data->dept_name . '</li>
                                            <li>Period: ' . $data->period . '</li>
                                        </ul>
                                        <div style="display:flex; justify-content:flex-start; margin-bottom:10px">
                                            <a href="' . $url . '/app/callback/dir-approve-callback.php?token=' . $data->token . '&action=approve&check=' . $name . '" style="margin-right:10px" class="btn btn-primary">Approve</a>
                                            <a href="' . $url . '/app/callback/dir-reject-callback.php?token=' . $data->token . '&action=reject&check=' . $name . '" style="margin-right:10px" class="btn btn-danger">Rejected</a>
                                            <a href="' . $url . '/app/callback/dir-revision-callback.php?token=' . $data->token . '&action=revision&check=' . $name . '" class="btn btn-warning">Revision</a>
                                        </div>
                                        <ul style="list-style-type: none; margin-left:-25px">
                                        <li>Aproval Log: </li>
                                        <li>HR: ' . $data->hr_check_by . ' - ' . Carbon::parse($data->hr_check_at)->locale('id-ID')->format('l, j F Y ; h:i:s a') . '</li>
                                    </ul>
                                        
                                        <p>For allowance details can be seen in the link below:</p>
                                        <a href="' . $url . '/view/sign/dir-sign.php?token=' . $data->token . '">View this request in HR Integrated system - flexy allowance app</a>
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
            $response['message'] = 'Allowance approved!';
            $response['status'] = \true;
            return $response;
        } catch (Exception $e) {
            $response['message'] = 'Something Went Wrong!';
            $response['status'] = \false;
            return $response;
        }
    }

    /**
     * @method untuk hr approve
     * @return email/bool
     */
    public function revision($request)
    {
        $url = $this->homeUrl->homeurl();
        $nomerAllowance = $request['nomerAllowance'];
        $checkBy = $request['hr_check_by'];
        $hrNotes = $request['hr_notes'];
        $updateTimestamp = Carbon::now();
        // update data allowance jika hr revisi
        $sql = "UPDATE allowance SET hr_approve=4, hr_check_by='$checkBy', hr_notes='$hrNotes', hr_check_at='$updateTimestamp', manager_approve=0, updated_at='$updateTimestamp' WHERE nomer='$nomerAllowance'";
        $query = static::$mysqli->query($sql);
        //ambil data allowance
        $data = self::contentEmail($nomerAllowance);

        $mail = new PHPMailer(true);
        $name = $data->name;
        $hrAdminEmail = $data->email;

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

            $urlPath = $url;
            $imagePath = $urlPath . '/public/img/logo-zekindo-comp.png';
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Flexy App - Allowance No: ' . $data->nomer . ' is revise by HR!';
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
                                    <p>Dear ' . $name . '</p>
                                    <p>Your allowance request is revision by HR, please check the following details:</p>
                                    <ul style="list-style-type: none; margin-left:-25px">
                                        <li><b>Status: Revise!</b></li>
                                        <li>Allowance ID: ' . $data->nomer . '</li>
                                        <li>Subject: ' . $data->subject . '</li>
                                        <li>Total: Rp. ' . \number_format($data->total, 0, ',', '.') . '</li>
                                        <li>Date: ' . $data->transaction_date . '</li>
                                        <li>Company: ' . $data->company_name . '</li>
                                        <li>Cost Center & Department: ' . $data->cost_center_name . '-' . $data->dept_name . '</li>
                                        <li>Period: ' . $data->period . '</li>
                                        <li>HR Notes: ' . $data->hr_notes . '</li>
                                    </ul>
                                  
                                    <ul style="list-style-type: none; margin-left:-25px">
                                    <li>Aproval Log: </li>
                                    <li>HR: ' . $data->hr_check_by . ' - ' . Carbon::parse($data->hr_check_at)->locale('id-ID')->format('l, j F Y ; h:i:s a') . '</li>
                                </ul>
                                    <b>Please login to the system to revise and resubmit.</b>
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
            $response['message'] = 'Allowance Revise!';
            $response['status'] = \true;
            return $response;
        } catch (Exception $e) {
            $response['message'] = 'Something Went Wrong!';
            $response['status'] = \false;
            return $response;
        }
    }

    /**
     * @method untuk hr approve
     * @return email/bool
     */
    public function rejected($request)
    {
        $url = $this->homeUrl->homeurl();
        $nomerAllowance = $request['nomerAllowance'];
        $checkBy = $request['hr_check_by'];
        $hrNotes = $request['hr_notes'];
        $updateTimestamp = Carbon::now();
        // update data jika reject
        $sql = "UPDATE allowance SET hr_approve=3, hr_check_by='$checkBy', hr_notes='$hrNotes', hr_check_at='$updateTimestamp', manager_approve=0, updated_at='$updateTimestamp' WHERE nomer='$nomerAllowance'";
        $query = static::$mysqli->query($sql);
        //ambil data allowance
        $data = self::contentEmail($nomerAllowance);

        $mail = new PHPMailer(true);
        $name = $data->name;
        $reuqestorEmail = $data->email;

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
            $mail->addAddress($reuqestorEmail);      //Add a recipient

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            $urlPath = $url;
            $imagePath = $urlPath . '/public/img/logo-zekindo-comp.png';
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Flexy App - Allowance No: ' . $data->nomer . 'is revise by HR!';
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
                                        <p>Dear ' . $name . '</p>
                                        <p>Your allowance request rejected by HR, please check the following details:</p>
                                        <ul style="list-style-type: none; margin-left:-25px">
                                            <li><b>Status: Rejected!</b></li>
                                            <li>Allowance ID: ' . $data->nomer . '</li>
                                            <li>Subject: ' . $data->subject . '</li>
                                            <li>Total: Rp. ' . \number_format($data->total, 0, ',', '.') . '</li>
                                            <li>Date: ' . $data->transaction_date . '</li>
                                            <li>Company: ' . $data->company_name . '</li>
                                            <li>Cost Center & Department: ' . $data->cost_center_name . '-' . $data->dept_name . '</li>
                                            <li>Period: ' . $data->period . '</li>
                                            <li>HR Notes: ' . $data->hr_notes . '</li>
                                        </ul>
                                      
                                        <ul style="list-style-type: none; margin-left:-25px">
                                        <li>Aproval Log: </li>
                                        <li>HR: ' . $data->hr_check_by . ' - ' . Carbon::parse($data->hr_check_at)->locale('id-ID')->format('l, j F Y ; h:i:s a') . '</li>
                                    </ul>
                                        <b>Please log in to the system for further action</b>
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
            $response['message'] = 'Allowance Rejected!';
            $response['status'] = \true;
            return $response;
        } catch (Exception $e) {
            $response['message'] = 'Something Went Wrong!';
            $response['status'] = \false;
            return $response;
        }
    }
    /**
     * @method untuk mendapatkan data allowance
     * untuk konten email
     */
    public static function contentEmail($nomerAllowance)
    {
        $sql2 = "SELECT nomer, transaction_date, nama AS subject, period, total,hr_check_by, hr_notes, hr_check_at, users.name, users.email, company.company_name, cost_center.cost_center_name, department.dept_name 
        FROM allowance LEFT JOIN users ON allowance.users_id = users.id_users
        LEFT JOIN company ON allowance.company_id = company.IdCompany
        LEFT JOIN cost_center ON allowance.cost_center_id = cost_center.id_cost_center
        LEFT JOIN department ON allowance.department_id = department.id_dept
        WHERE allowance.nomer = '$nomerAllowance'";
        $query = static::$mysqli->query($sql2);

        return $query->fetch_object();
    }
}
