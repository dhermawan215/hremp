<?php


namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;

class CostCenterController
{
    protected $db;
    private static $mysqli;
    private static $user;
    public $homeUrl;

    public function __construct()
    {
        session_start();
        $this->db = new Databases;
        static::$mysqli = $this->db->connect();
        $this->homeUrl = new UriController;
        static::$user = $_SESSION['user'];
    }
    /**
     * @method untuk data table cost center
     * @return array json
     */
    public function dataCostCenter($request)
    {
        $url = $this->homeUrl->homeurl();

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_cost_center) AS counts FROM cost_center JOIN company 
        ON cost_center.company_id=company.IdCompany";
        $resultQuery = static::$mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_cost_center, cost_center_name, company.company_name AS com_name FROM cost_center JOIN company 
            ON cost_center.company_id=company.IdCompany WHERE cost_center_name LIKE '%$search%' OR company.company_name LIKE '%$search%' ORDER BY cost_center.id_cost_center ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_cost_center) AS counts FROM cost_center JOIN company 
            ON cost_center.company_id=company.IdCompany WHERE cost_center_name LIKE '%$search%' OR company.company_name LIKE '%$search%' ORDER BY cost_center.id_cost_center ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_cost_center, cost_center_name, company.company_name AS com_name FROM cost_center JOIN company 
            ON cost_center.company_id=company.IdCompany ORDER BY cost_center.id_cost_center ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);
        }

        $response = [];
        $arr = [];

        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id_cost_center);
            $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $row->id_cost_center . '">';
            $data['rnum'] = $i;
            $data['company'] = $row->com_name;
            $data['name'] = $row->cost_center_name;
            $data['action'] = '<a href="' . $url . '/view/admin-flexy/cost-center-edit.php?costcenter=' . $id . '" title="edit cost center" class="btn btn-primary btn-sm btn-edit" id="btn-edit"><i class="bi bi-pencil-square"></i></a><a href="' . $url . '/view/admin-flexy/cost-center-department.php?costcenter=' . $id . '" class="btn btn-success btn-sm btn-detail ms-1" id="btn-detail" title="detail cost center"><i class="bi bi-eye"></i></a>';
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
     * @method untuk menyimpan data cost center
     * @return bool
     */
    public function store($request)
    {
        $name = $request['cost_center_name'];
        $companyId = $request['company'];
        $timestamp = \date('Y-m-d H:i:s');
        $createdBy = static::$user['name'];
        $sql = "INSERT INTO cost_center(company_id,cost_center_name,created_by,created_at,updated_at)
        VALUES($companyId, '$name', '$createdBy', '$timestamp','$timestamp')";
        $query = static::$mysqli->query($sql);
        return $query;
    }
    /**
     * @method untuk edit data cost center
     * @return array
     */
    public function edit($request)
    {
        $id = \base64_decode($request['formValue']);
        $sql = "SELECT company_id as company, company.company_name, cost_center_name
        FROM cost_center JOIN company ON  cost_center.company_id=company.IdCompany WHERE id_cost_center=$id";
        $query = static::$mysqli->query($sql);
        $dataDb = $query->fetch_object();

        return $dataDb;
    }
    /**
     * @method untuk mengupdate cost center
     * @return bool
     */
    public function update($request)
    {
        $id = \base64_decode($request['formValue']);
        $name = $request['cost_center_name'];
        $companyId = $request['company'];
        $timestamp = \date('Y-m-d H:i:s');
        $sql = "UPDATE cost_center SET 
        company_id=$companyId, cost_center_name='$name', updated_at='$timestamp' 
        WHERE id_cost_center=$id";
        $query = static::$mysqli->query($sql);
        return $query;
    }
    /**
     * @method untuk menghapus data detail cost center
     * @return bool
     */
    public function delete($ids)
    {
        $idsToString = \implode(",", $ids);
        $sql = "DELETE FROM cost_center WHERE id_cost_center IN ($idsToString)";
        $query = static::$mysqli->query($sql);
        return $query;
    }
    /**
     * @method untuk melihat detail cost center-department
     * @return object
     */
    public function detail($ids)
    {
        $id = \base64_decode($ids);
        $sql = "SELECT company.company_name, cost_center_name
        FROM cost_center JOIN company ON  cost_center.company_id=company.IdCompany WHERE id_cost_center=$id LIMIT 1";
        $query = static::$mysqli->query($sql);
        return $query->fetch_object();
    }
    /**
     * @param $id (company_id)
     * @method untuk ambil data cost center dropdown(user request)
     * @return object
     */
    public function getCostCenterDropdown($id)
    {
        $list = [];
        $sql = "SELECT id_cost_center, cost_center_name FROM cost_center WHERE company_id=$id";
        $query = static::$mysqli->query($sql);

        if ($query->num_rows == 0) {
            $list['id'] = 0;
            $list['text'] = "empty data";
            $arr[] = $list;
        }

        while ($row = $query->fetch_object()) {
            $list['id'] = \base64_encode($row->id_cost_center);
            $list['text'] = $row->cost_center_name;
            $arr[] = $list;
        }

        $response['item'] = $arr;
        return $response;
    }
}
