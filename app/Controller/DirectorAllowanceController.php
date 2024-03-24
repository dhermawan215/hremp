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

class DirectorAllowanceController
{
    protected $db;
    private static $mysqli;
    private static $user;
    public $homeUrl;
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
        if ($fetch->hr_approve == self::approve && $fetch->manager_approve == self::requested) {
            $btnApprove = '<button type="button" class="btn btn-outline-primary" id="btn-approve" data-approve="' . $dataButtonId . '">Approve</button>';
            $btnRevision = ' <button type="button" class="btn btn-outline-warning" id="btn-revision" data-revision="' . $dataButtonId . '" data-bs-toggle="modal" data-bs-target="#revision-modal">Revision</button>';
            $btnRejected = '<button type="button" class="btn btn-outline-danger" id="btn-rejected" data-rejected="' . $dataButtonId . '" data-bs-toggle="modal" data-bs-target="#rejected-modal">Rejected</button>';
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
    public function direcctorNeedCheckList($request)
    {
        $url = $this->homeUrl->homeurl();
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_allowance) AS counts FROM allowance WHERE manager_approve='1'";
        $resultQuery = static::$mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_allowance, nomer, nama, company.company_name, transaction_date, period, total, hr_approve, manager_approve, users.name as requestor FROM allowance
            JOIN company ON allowance.company_id=company.IdCompany JOIN users ON allowance.users_id=users.id_users
            WHERE allowance.manager_approve='1' AND (nama LIKE '%$search%' OR nomer LIKE '%$search%' OR users.name LIKE '%$search%') ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_allowance) AS counts FROM allowance JOIN company ON allowance.company_id=company.IdCompany JOIN users ON allowance.userS_id=users.id_users WHERE allowance.manager_approve='1' AND (nama LIKE '%$search%' OR nomer LIKE '%$search%' OR users.name LIKE '%$search%') ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_allowance, nomer, nama, company.company_name, transaction_date, period, total, hr_approve, manager_approve, users.name as requestor FROM allowance JOIN company ON allowance.company_id=company.IdCompany 
            JOIN users ON allowance.users_id=users.id_users WHERE allowance.manager_approve='1' ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
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

            $data['action'] = '<div class="d-flex"><a href="' . $url . '/view/director-panel/allowance-detail.php?detail=' . $row->nomer . '" id="#btn-detail" class="btn btn-sm btn-success ms-1 btn-detail" title="detail allowance request"><i class="bi bi-eye"></i></a></div>';
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
    public function directorApproved($request)
    {
        $url = $this->homeUrl->homeurl();
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_allowance) AS counts FROM allowance WHERE manager_approve='2'";
        $resultQuery = static::$mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_allowance, nomer, nama, company.company_name, transaction_date, period, total, hr_approve, manager_approve, users.name as requestor FROM allowance
            JOIN company ON allowance.company_id=company.IdCompany JOIN users ON allowance.users_id=users.id_users
            WHERE allowance.manager_approve='2' AND (nama LIKE '%$search%' OR nomer LIKE '%$search%' OR users.name LIKE '%$search%') ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_allowance) AS counts FROM allowance JOIN company ON allowance.company_id=company.IdCompany JOIN users ON allowance.userS_id=users.id_users WHERE allowance.manager_approve='2' AND (nama LIKE '%$search%' OR nomer LIKE '%$search%' OR users.name LIKE '%$search%') ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_allowance, nomer, nama, company.company_name, transaction_date, period, total, hr_approve, manager_approve, users.name as requestor FROM allowance JOIN company ON allowance.company_id=company.IdCompany 
            JOIN users ON allowance.users_id=users.id_users WHERE allowance.manager_approve='2' ORDER BY id_allowance ASC LIMIT $limit OFFSET $offset";
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

            $data['action'] = '<div class="d-flex"><a href="' . $url . '/view/director-panel/allowance-detail.php?detail=' . $row->nomer . '" id="#btn-detail" class="btn btn-sm btn-success ms-1 btn-detail" title="detail allowance request"><i class="bi bi-eye"></i></a></div>';
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
    }

    /**
     * @method untuk hr approve
     * @return email/bool
     */
    public function revision($request)
    {
    }

    /**
     * @method untuk hr approve
     * @return email/bool
     */
    public function rejected($request)
    {
    }
}
