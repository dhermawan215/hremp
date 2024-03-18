<?php

namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
require_once 'AktivitasController.php';
require_once 'AktivitasDetailController.php';
require_once 'AllowanceController.php';

include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;
use App\Controller\AktivitasController;
use App\Controller\AktivitasDetailController;



class AllowanceDetailController
{
    protected $db;
    private static $mysqli;
    private static $user;
    public $homeUrl;
    private $aktivitas;
    private $aktivitasDetail;

    protected const pending = 0;
    protected const requested = 1;
    protected const approve = 2;
    protected const rejected = 3;
    protected const revision = 4;

    public function __construct()
    {
        session_start();
        $this->db = new Databases;
        static::$mysqli = $this->db->connect();
        $this->homeUrl = new UriController;
        $this->aktivitas = new AktivitasController;
        $this->aktivitasDetail = new AktivitasDetailController;
        new AllowanceController;
        static::$user = $_SESSION['user'];
    }
    /**
     * @method untuk dropdown activity
     * @return array json
     */
    public function dropdownActivity($request)
    {
        return $this->aktivitas->getActivityDropdown($request);
    }
    /**
     * @method untuk dropdown activity detail
     * @return array json
     */
    public function dropdownActivityDetail($request)
    {
        return $this->aktivitasDetail->getDetailDropdown($request['activity']);
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
        $allowance_id = $request['allowance'];
        $activity = $request['activity'];
        $activity_detail = $request['activity_detail'];
        $deskripsi = $request['deskripsi'];
        $jumlah_biaya_bon = $request['jumlah_biaya_bon'];
        $jumlah_biaya_klaim = $request['jumlah_biaya_klaim'];
        $tanggal_aktivitas = $request['tanggal_aktivitas'];
        $kategoriTertanggung = $request['kategori_tertanggung'];
        $namaTertanggung = $request['nama_tertanggung'];

        try {
            //begin transaction
            static::$mysqli->begin_transaction();

            $sql = "INSERT INTO allowance_detail(allowance_id, aktivitas_id, aktivitas_detail_id, kategori_tertanggung, nama_tertanggung, deskripsi, jumlah_biaya_bon, jumlah_biaya_klaim, tanggal_aktivitas, created_at, updated_at)
            VALUES($allowance_id, $activity,$activity_detail, '$kategoriTertanggung', '$namaTertanggung', '$deskripsi',
            $jumlah_biaya_bon, $jumlah_biaya_klaim, '$tanggal_aktivitas', '$timestamp','$timestamp')";

            $query = static::$mysqli->query($sql);
            // commit transaction
            static::$mysqli->commit();
            $data['success'] = \true;
            return $data;
        } catch (\Throwable $th) {
            static::$mysqli->rollback();
            $data['success'] = \false;
            return $data;
        }
    }
    /**
     * @method untuk menampilkan item data tabel di detail allowance
     * @return json
     */
    public function myDetailAllowance($request)
    {
        $allowance =  AllowanceController::getIdAllowance($request['nomer']);
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
            if ($allowance->hr_approve == self::requested && $allowance->manager_approve == self::pending) {
                $cbox = '';
                $btnEdit = '';
            } else if ($allowance->hr_approve == self::approve && $allowance->manager_approve == self::requested) {
                $cbox = '';
                $btnEdit = '';
            } else if ($allowance->hr_approve == self::approve && $allowance->manager_approve == self::approve) {
                $cbox = '';
                $btnEdit = '';
            } else {
                $cbox = '<input type="checkbox" class="data-item-cbox" value="' . $row->id_all_det . '">';
                $btnEdit = '<a href="' . $url . '/view/flexy-allowance/allowance-detail-edit.php?detail=' . $id . '&allowance=' . $request['nomer'] . '" id="#btn-edit" class="btn btn-sm btn-primary btn-edit" title="edit"><i class="bi bi-pencil-square"></i></a>';
            }
            $data['cbox'] = $cbox;
            $data['rnum'] = $i;
            $data['activity'] = $row->activity;
            $data['detail'] = $row->nama_detail;
            $data['desc'] = $row->deskripsi;
            switch ($row->kategori_tertanggung) {
                case 'nama_suami_istri':
                    $dependents = 'Husban/Wife';
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
            $data['action'] = $btnEdit;
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
     * @method untuk delete data item detail request
     */
    public function deleteItem($request)
    {
        $ids = $request['ids'];
        $idsToString = \implode(",", $ids);
        $sql = "DELETE FROM allowance_detail WHERE id_all_det IN ($idsToString)";
        $query = static::$mysqli->query($sql);

        return $query;
    }
    /**
     * @method untuk edit data item detail
     */
    public function edit($id)
    {
        $ids = \base64_decode($id);
        $sql = "SELECT allowance_detail.aktivitas_id, allowance_detail.aktivitas_detail_id, kategori_tertanggung, nama_tertanggung, allowance_detail.deskripsi, jumlah_biaya_bon, jumlah_biaya_klaim,
        tanggal_aktivitas, aktivitas.nama AS activity, aktivitas_detail.nama_detail FROM allowance_detail JOIN aktivitas ON allowance_detail.aktivitas_id=aktivitas.id_aktivitas
        JOIN aktivitas_detail ON allowance_detail.aktivitas_detail_id=aktivitas_detail.id_aktivitas_detail WHERE allowance_detail.id_all_det=$ids";

        $query = static::$mysqli->query($sql);
        $response = $query->fetch_object();
        switch ($response->kategori_tertanggung) {
            case 'nama_suami_istri':
                $dependents = 'Husband/wife';
                break;

            case 'anak1':
                $dependents = 'First child';
                break;

            case 'anak1':
                $dependents = 'Second child';
                break;

            case 'anak3':
                $dependents = 'The third child';
                break;

            default:
                $dependents = 'Your self';
                break;
        }
        $data = [
            'aktivitas' => $response->aktivitas_id,
            'aktivitas_detail' => $response->aktivitas_detail_id,
            'kategori_tertanggung' => $response->kategori_tertanggung,
            'kategori_tertanggung_nama' => $dependents,
            'nama_tertanggung' => $response->nama_tertanggung,
            'deskripsi' => $response->deskripsi,
            'jumlah_biaya_bon' => $response->jumlah_biaya_bon,
            'jumlah_biaya_klaim' => $response->jumlah_biaya_klaim,
            'tanggal_aktivitas' => $response->tanggal_aktivitas,
            'nama_aktivitas' => $response->activity,
            'nama_detail' => $response->nama_detail,
        ];

        return $data;
    }

    public function update($request)
    {
        $timestamp = \date('Y-m-d H:i:s');
        $idItem = \base64_decode($request['item']);
        $activity = $request['activity'];
        $activity_detail = $request['activity_detail'];
        $deskripsi = $request['deskripsi'];
        $jumlah_biaya_bon = $request['jumlah_biaya_bon'];
        $jumlah_biaya_klaim = $request['jumlah_biaya_klaim'];
        $tanggal_aktivitas = $request['tanggal_aktivitas'];
        $kategoriTertanggung = $request['kategori_tertanggung'];
        $namaTertanggung = $request['nama_tertanggung'];

        $sql = "UPDATE allowance_detail SET aktivitas_id=$activity, aktivitas_detail_id=$activity_detail,
        kategori_tertanggung='$kategoriTertanggung', nama_tertanggung='$namaTertanggung', deskripsi='$deskripsi',
        jumlah_biaya_bon=$jumlah_biaya_bon, jumlah_biaya_klaim=$jumlah_biaya_klaim, tanggal_aktivitas='$tanggal_aktivitas', updated_at='$timestamp'
        WHERE id_all_det=$idItem";

        $query = static::$mysqli->query($sql);

        return $query;
    }
    /**
     * @method untuk mendapatkan data keluarga(dropdown)
     */
    public function getFamilyInsured($request)
    {
        $fieldCondition = $request['field'];
        $employeeId = static::$user['employee'];
        if ($fieldCondition == 'self') {
            $response = [
                'nama_tertanggung' => static::$user['name'],
            ];
            return $response;
        } else {
            $sql = "SELECT $fieldCondition AS nama_tertanggung FROM emp_families WHERE emp_id=$employeeId";
            $query = static::$mysqli->query($sql);
            // $namaTertanggungDb = $query->fetch_object();
            // $response = [
            //     'nama_tertanggung' => $namaTertanggungDb,
            // ];
            return $query->fetch_object();
        }
    }
}
