<?php

namespace App\Controller;

use App\Database\Databases;
use App\Controller\UriController;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

class StatusEmployeeController
{
    public function __construct()
    {
        $this->db = new Databases;
        $this->home = new UriController;
    }

    public function getDataStatus($request)
    {
        $url = $this->home->homeurl();

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id_status) AS counts FROM status_emp";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT * FROM status_emp WHERE status_name LIKE '%$search%' ORDER BY id_status ASC LIMIT $limit OFFSET $offset ";
            $resulData = $mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_status) AS counts FROM status_emp WHERE status_name LIKE '%$search%' ORDER BY id_status ASC LIMIT $limit OFFSET $offset";
            $resulCountData = $mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT * FROM status_emp ORDER BY id_status ASC LIMIT $limit OFFSET $offset";
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
            $id = base64_encode($row->id_status);
            $data['rnum'] = $i;
            $data['name'] = $row->status_name;
            $data['action'] = "<div class='d-flex'><a href='$url/view/pages/status/edit.php?data=$id' class='text-decoration-none align-middle' title='edit'><i class='bi bi-pencil-square'></i></a></div>";
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
        $name = $request['status_name'];
        $sqlInput = "INSERT INTO status_emp(status_name) VALUES('$name')";
        $mysqli = $this->db->connect();
        $resulSave = $mysqli->query($sqlInput);

        return $resulSave;
    }

    public function edit($id)
    {
        $sqlEdit = "SELECT * FROM status_emp WHERE id_status=$id LIMIT 1";
        $mysqli = $this->db->connect();
        $resulEdit = $mysqli->query($sqlEdit);
        $fetchEdit = $resulEdit->fetch_object();

        return $fetchEdit;
    }

    public function update($request)
    {
        $id = $request['id'];
        $name = $request['status_name'];
        unset($request['_token']);
        $sqlEdit = "UPDATE status_emp SET status_name='$name' WHERE id_status=$id";
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
        $sqlDelete = "DELETE FROM status_emp WHERE id_status=$id";
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

            $sqlItem = "SELECT * FROM status_emp WHERE status_name LIKE '%$search%' LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(id_status) AS count FROM status_emp WHERE status_name LIKE '%$search%' LIMIT 10 OFFSET $offset";
            $mysqli = $this->db->connect();

            $dataItem = $mysqli->query($sqlItem);
            $dataCount = $mysqli->query($sqlCount);

            $counts = $dataCount->fetch_object();
        } else {
            $perPage = $request['page'];

            $resultCount = 10;

            $offset = ($perPage - 1) * $resultCount;

            $sqlItem = "SELECT * FROM status_emp LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(id_status) AS count FROM status_emp LIMIT 10 OFFSET $offset";
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
            $list['id'] = $row->id_status;
            $list['text'] = $row->status_name;
            $arr[] = $list;
        }

        $response['total_count'] = $counts;
        $response['items'] = $arr;

        return $response;
    }
}
