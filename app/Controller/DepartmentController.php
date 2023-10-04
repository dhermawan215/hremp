<?php

namespace App\Controller;

require_once '../../app/Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

use App\Database\Databases;
use App\Controller\UriController;

class DepartmentController
{
    public $user;
    private $db;
    public $home;

    public function __construct()
    {
        session_start();
        $this->db = new Databases();
        $this->home = new UriController();
        $this->user = $_SESSION['user'];
    }

    public function getDataDepartment($request)
    {
        $url = $this->home->homeurl();

        $users2 = (object) $this->user;

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_dept) AS counts FROM department";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT * FROM department WHERE dept_name LIKE '%$search%' ORDER BY id_dept ASC LIMIT $limit OFFSET $offset ";
            $resulData = $mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_dept) AS counts FROM department WHERE dept_name LIKE '%$search%' ORDER BY id_dept ASC LIMIT $limit OFFSET $offset";
            $resulCountData = $mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT * FROM department ORDER BY id_dept ASC LIMIT $limit OFFSET $offset";
            $resulData = $mysqli->query($sqlSearch);
        }

        $response = [];
        if ($resulData->num_rows == 0) {
            $data['rnum'] = "#";
            $data['name'] = "Data Kosong";
            $data['action'] = "Data Kosong";
            $arr[] = $data;
        }


        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id_dept);
            $data['rnum'] = $i;
            $data['name'] = $row->dept_name;
            if ($users2->roles == '1') {
                $deleteBtn = "<button id='btnDelete' class='btndel ms-2 text-danger border-0' data-id='$row->id_dept'><i class='bi bi-trash'></i></button>";
            } else {
                $deleteBtn = '';
            }

            $data['action'] = "<div class='d-flex'><a href='$url/view/pages/department/edit.php?data=$id' class='text-decoration-none align-middle' title='edit'><i class='bi bi-pencil-square'></i></a>$deleteBtn</div>";
            $arr[] = $data;
            $i++;
        }

        $response['draw'] = $draw;
        $response['recordsTotal'] = $totalData;
        $response['recordsFiltered'] = $totalFiltered;
        $response['data'] = $arr;

        return $response;
    }

    public function store($request)
    {
        unset($request['_token']);
        $name = $request['dept_name'];
        $sqlInput = "INSERT INTO department(dept_name) VALUES('$name')";
        $mysqli = $this->db->connect();
        $resulSave = $mysqli->query($sqlInput);

        return $resulSave;
    }

    public function edit($id)
    {
        $sqlEdit = "SELECT * FROM department WHERE id_dept=$id LIMIT 1";
        $mysqli = $this->db->connect();
        $resulEdit = $mysqli->query($sqlEdit);
        $fetchEdit = $resulEdit->fetch_object();

        return $fetchEdit;
    }

    public function update($request)
    {
        $id = $request['id'];
        $name = $request['dept_name'];
        unset($request['_token']);
        $sqlEdit = "UPDATE department SET dept_name='$name' WHERE id_dept=$id";
        $mysqli = $this->db->connect();
        $resulEdit = $mysqli->query($sqlEdit);

        if ($resulEdit) {
            return true;
        } else {
            return false;
        }
    }

    public function destroy($id)
    {
        $sqlDelete = "DELETE FROM department WHERE id_dept=$id";
        $mysqli = $this->db->connect();
        $resulDelete = $mysqli->query($sqlDelete);

        if ($resulDelete == true) {
            return true;
        } else {
            return false;
        }
    }


    public function getDropdown($request)
    {
        $list = [];

        if (isset($request['search'])) {
            $search = $request['search'];
            $perPage = $request['page'];

            $resultCount = 10;

            $offset = ($perPage - 1) * $resultCount;

            $sqlItem = "SELECT * FROM department WHERE dept_name LIKE '%$search%' LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(id_dept) AS count FROM department WHERE dept_name LIKE '%$search%' LIMIT 10 OFFSET $offset";
            $mysqli = $this->db->connect();

            $dataItem = $mysqli->query($sqlItem);
            $dataCount = $mysqli->query($sqlCount);

            $counts = $dataCount->fetch_object();
        } else {
            $perPage = $request['page'];

            $resultCount = 10;

            $offset = ($perPage - 1) * $resultCount;

            $sqlItem = "SELECT * FROM department LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(id_dept) AS count FROM department LIMIT 10 OFFSET $offset";
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
            $list['id'] = $row->id_dept;
            $list['text'] = $row->dept_name;
            $arr[] = $list;
        }

        $response['total_count'] = $counts;
        $response['items'] = $arr;

        return $response;
    }
}
