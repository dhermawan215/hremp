<?php

namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;

class CompanyController
{

    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }

    public function getDataCompany($request)
    {
        $url = $this->home->homeurl();

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(IdCompany) AS counts FROM company";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT * FROM company WHERE company_name LIKE '%$search%' ORDER BY IdCompany ASC LIMIT $limit OFFSET $offset ";
            $resulData = $mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(IdCompany) AS counts FROM company WHERE company_name LIKE '%$search%' ORDER BY idCompany ASC LIMIT $limit OFFSET $offset";
            $resulCountData = $mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT * FROM company ORDER BY IdCompany ASC LIMIT $limit OFFSET $offset";
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
            $id = base64_encode($row->IdCompany);
            $data['rnum'] = $i;
            $data['name'] = $row->company_name;
            $data['action'] = "<div class='d-flex'><a href='$url/view/pages/company/edit.php?data=$id' class='text-decoration-none align-middle' title='edit'><i class='bi bi-pencil-square'></i></a><button id='btnDelete' class='btndel ms-2 text-danger border-0' data-id='$row->IdCompany'><i class='bi bi-trash'></i></button></div>";
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
        $name = $request['company_name'];
        $sqlInput = "INSERT INTO company(company_name) VALUES('$name')";
        $mysqli = $this->db->connect();
        $resulSave = $mysqli->query($sqlInput);

        return $resulSave;
    }

    public function edit($id)
    {
        $sqlEdit = "SELECT * FROM company WHERE IdCompany=$id LIMIT 1";
        $mysqli = $this->db->connect();
        $resulEdit = $mysqli->query($sqlEdit);
        $fetchEdit = $resulEdit->fetch_object();

        return $fetchEdit;
    }

    public function update($request)
    {
        $id = $request['id'];
        $name = $request['company_name'];
        unset($request['_token']);
        $sqlEdit = "UPDATE company SET company_name='$name' WHERE IdCompany=$id";
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
        $sqlDelete = "DELETE FROM company WHERE IdCompany=$id";
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

            $sqlItem = "SELECT * FROM company WHERE company_name LIKE '%$search%' LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(IdCompany) AS count FROM company WHERE company_name LIKE '%$search%' LIMIT 10 OFFSET $offset";
            $mysqli = $this->db->connect();

            $dataItem = $mysqli->query($sqlItem);
            $dataCount = $mysqli->query($sqlCount);

            $counts = $dataCount->fetch_object();
        } else {
            $perPage = $request['page'];

            $resultCount = 10;

            $offset = ($perPage - 1) * $resultCount;

            $sqlItem = "SELECT * FROM company LIMIT 10 OFFSET $offset";
            $sqlCount = "SELECT COUNT(IdCompany) AS count FROM company LIMIT 10 OFFSET $offset";
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
            $list['id'] = $row->IdCompany;
            $list['text'] = $row->company_name;
            $arr[] = $list;
        }

        $response['total_count'] = $counts;
        $response['items'] = $arr;

        return $response;
    }
}
