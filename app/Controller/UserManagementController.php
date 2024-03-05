<?php

namespace App\Controller;

require '../Database/Databases.php';
require 'UriController.php';

use app\Database\Databases;
use App\Controller\UriController;

class UserManagementController
{
    protected $isActive = false;
    protected $db;
    public $homeUrl;
    private static $mysqli;

    public function __construct()
    {
        $this->db = new Databases;
        static::$mysqli = $this->db->connect();
        $this->homeUrl = new UriController;
    }

    public function dataUser($request)
    {
        $url = $this->homeUrl->homeurl();
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_users) AS counts FROM users WHERE roles>='2'";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT id_users, employee_id, name, email, roles, active FROM users  WHERE roles>='2' AND name LIKE '%$search%' OR email LIKE '%$search%' ORDER BY id_users ASC LIMIT $limit OFFSET $offset ";
            $resulData = $mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_users) AS counts FROM users WHERE roles>='2' AND  name LIKE '%$search%' OR email LIKE '%$search%' ORDER BY id_users ASC LIMIT $limit OFFSET $offset";
            $resulCountData = $mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_users, employee_id, name, email, roles, active FROM users WHERE roles>='2' ORDER BY id_users ASC LIMIT $limit OFFSET $offset";
            $resulData = $mysqli->query($sqlSearch);
        }

        $response = [];
        $arr = [];

        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id_users);
            $data['rnum'] = $i;
            $data['name'] = $row->name;
            $data['email'] = $row->email;
            if ($row->active == 'true') {
                $check = 'checked';
            } else {
                $check = '';
            }
            $data['active'] = '<div class="form-check form-switch"><input class="form-check-input activeuser" type="checkbox" data-toggle="' . $id . '" id="flexSwitchCheckDefault" ' . $check . '></div>';
            $data['employee'] = $row->employee_id ? '<a class="btn btn-sm btn-success btn-info-emp" title="connected to employee" data-employee="' . $id . '" data-bs-toggle="modal" data-bs-target="#modal-info-employee"><i class="bi bi-check-square"></i></a>' : '<a class="btn btn-sm btn-danger btn-info-emp" title="not connect" data-employee="' . $id . '" data-bs-toggle="modal" data-bs-target="#modal-info-employee"><i class="bi bi-x-circle"></i></a>';
            $data['action'] = '<a href="' . $url . '/view/pages/admin/user-employee.php?user=' . $id . '&name=' . $row->name . '" class="btn btn-sm btn-primary"><i class="bi bi-person-fill-gear"></i> User Employee</a>';
            if ($row->roles == '2') {
                $roles = 'HR';
            }
            if ($row->roles == '3') {
                $roles = 'User';
            }
            $data['roles'] = $roles;
            $arr[] = $data;
            $i++;
        }

        $response['draw'] = $draw;
        $response['recordsTotal'] = $totalData;
        $response['recordsFiltered'] = $totalFiltered;
        $response['data'] = $arr;

        return $response;
    }

    public function updateActive($request)
    {
        $id = base64_decode($request['cbxValue']);
        $isActive = $request['acValue'];

        $sql = "UPDATE users SET active='$isActive' WHERE id_users='$id'";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }

    // employe dropdown
    public function getEmployeeDropDown($request)
    {
        $list = [];

        if (isset($request['search'])) {
            $search = $request['search'];
            $perPage = $request['page'];

            $resultCount = 10;

            $offset = ($perPage - 1) * $resultCount;

            $sqlItem = "SELECT id_employee, nama FROM employee WHERE nama LIKE '%$search%' AND  (is_resigned='0' AND status_emp='1') LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(id_employee) AS count FROM employee WHERE nama LIKE '%$search%' AND (is_resigned='0' AND status_emp='1') LIMIT 10 OFFSET $offset";
            $mysqli = $this->db->connect();

            $dataItem = $mysqli->query($sqlItem);
            $dataCount = $mysqli->query($sqlCount);

            $counts = $dataCount->fetch_object();
        } else {
            $perPage = $request['page'];

            $resultCount = 10;

            $offset = ($perPage - 1) * $resultCount;

            $sqlItem = "SELECT id_employee, nama FROM employee WHERE is_resigned='0' AND status_emp='1' LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(id_employee) AS count FROM employee WHERE is_resigned='0' LIMIT 10 OFFSET $offset";
            $mysqli = $this->db->connect();

            $dataItem = $mysqli->query($sqlItem);
            $dataCount = $mysqli->query($sqlCount);

            $counts = $dataCount->fetch_object();
        }

        if ($dataItem->num_rows == 0) {
            $list['id'] = 0;
            $list['text'] = "Data Kosong";
            $arr[] = $list;
        }

        while ($row = $dataItem->fetch_object()) {
            $list['id'] = $row->id_employee;
            $list['text'] = $row->nama;
            $arr[] = $list;
        }

        $response['total_count'] = $counts;
        $response['items'] = $arr;

        return $response;
    }

    public function updateUserEmployee($request)
    {
        $id = \base64_decode($request['user']);
        $employeeId = $request['employee'];

        $sql = "UPDATE users SET employee_id='$employeeId' WHERE id_users='$id'";

        $result = static::$mysqli->query($sql);

        return $result;
    }

    public function infoEmployeeConnect($request)
    {
        $id = \base64_decode($request['uvalue']);

        $sql = "SELECT name,email, employee.nip, employee.nama FROM users JOIN
        employee ON users.employee_id=employee.id_employee WHERE id_users=$id";

        $result = static::$mysqli->query($sql);
        $dataDb = $result->fetch_object();

        if (!\is_null($dataDb)) {
            $dataHtml = ' <ul>
            <li>Status connect to employee: connected</li>
            <li>Username: ' . $dataDb->name . '</li>
            <li>Email: ' . $dataDb->email . '</li>
            <li>Employee name: ' . $dataDb->nama . '</li>
            <li>NIP: ' . $dataDb->nip . '</li>
            </ul>';
        } else {
            $dataHtml = ' <ul>
            <li>Status connect to employee: not conected, please connect in action user employee</li>
            </ul>';
        }
        return $dataHtml;
    }
}
