<?php


namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;

class CostCenterDepartmentController
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
    public function costCenterDepartment($request)
    {
        $url = $this->homeUrl->homeurl();

        $draw = $request['draw'];
        $costCenterId = \base64_decode($request['costcenter']);
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_cost_department) AS counts FROM cost_center_department JOIN cost_center ON cost_center_department.cost_center_id=cost_center.id_cost_center
        JOIN department ON cost_center_department.department_id=department.id_dept
        JOIN company ON cost_center.company_id=company.IdCompany WHERE cost_center_department.cost_center_id=$costCenterId";
        $resultQuery = static::$mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_cost_department, cost_center_id, department_id, cost_center.cost_center_name, company.company_name, department.dept_name
            FROM cost_center_department JOIN cost_center ON cost_center_department.cost_center_id=cost_center.id_cost_center
            JOIN department ON cost_center_department.department_id=department.id_dept
            JOIN company ON cost_center.company_id=company.IdCompany WHERE cost_center_department.cost_center_id=$costCenterId AND (cost_center.cost_center_name LIKE '%$search%' OR department.dept_name LIKE '%$search%')
            ORDER BY id_cost_department ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_cost_department) AS counts FROM cost_center_department JOIN cost_center ON cost_center_department.cost_center_id=cost_center.id_cost_center
            JOIN department ON cost_center_department.department_id=department.id_dept
            JOIN company ON cost_center.company_id=company.IdCompany WHERE cost_center_department.cost_center_id=$costCenterId AND (cost_center.cost_center_name LIKE '%$search%' OR department.dept_name LIKE '%$search%')
            ORDER BY id_cost_department ASC LIMIT $limit OFFSET $offset";
            $resulCountData = static::$mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_cost_department, cost_center_id, department_id, cost_center.cost_center_name, company.company_name, department.dept_name
            FROM cost_center_department JOIN cost_center ON cost_center_department.cost_center_id=cost_center.id_cost_center
            JOIN department ON cost_center_department.department_id=department.id_dept
            JOIN company ON cost_center.company_id=company.IdCompany WHERE cost_center_department.cost_center_id=$costCenterId
            ORDER BY id_cost_department ASC LIMIT $limit OFFSET $offset";
            $resulData = static::$mysqli->query($sqlSearch);
        }

        $response = [];
        $arr = [];

        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id_cost_department);
            $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $row->id_cost_department . '">';
            $data['rnum'] = $i;
            $companyName = $row->company_name ? $row->company_name : 'empty';
            $costCenterName = $row->cost_center_name ? $row->cost_center_name : 'empty';
            $data['comcost'] = $companyName . ' - ' . $costCenterName;
            $data['department'] = $row->dept_name;
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
        $departmentId = $request['department'];
        $costCenterId = \base64_decode($request['cost_center']);
        $timestamp = \date('Y-m-d H:i:s');
        $createdBy = static::$user['name'];

        $sql = "INSERT INTO cost_center_department(cost_center_id,department_id,created_by,created_at,updated_at)
        VALUES($costCenterId,$departmentId,'$createdBy','$timestamp','$timestamp')";

        $query = static::$mysqli->query($sql);
        return $query;
    }
    /**
     * @method untuk edit data cost center
     * @return array
     */
    public function edit($request)
    {
    }
    /**
     * @method untuk mengupdate cost center
     * @return bool
     */
    public function update($request)
    {
    }
    /**
     * @method untuk menghapus data detail aktivitas
     * @return bool
     */
    public function delete($ids)
    {
        $idsToString = \implode(",", $ids);
        $sql = "DELETE FROM cost_center_department WHERE id_cost_department IN ($idsToString)";
        $query = static::$mysqli->query($sql);
        return $query;
    }
}
