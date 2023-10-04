<?php

namespace App\Controller;

require '../Database/Databases.php';

use app\Database\Databases;

class UserManagementController
{
    protected $isActive = false;

    public function __construct()
    {
        $this->db = new Databases;
    }

    public function dataUser($request)
    {
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
            $sqlSearch = "SELECT id_users, name, email, roles, active FROM users  WHERE roles>='2' AND name LIKE '%$search%' OR email LIKE '%$search%' ORDER BY id_users ASC LIMIT $limit OFFSET $offset ";
            $resulData = $mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id_users) AS counts FROM users WHERE roles>='2' AND  name LIKE '%$search%' OR email LIKE '%$search%' ORDER BY id_users ASC LIMIT $limit OFFSET $offset";
            $resulCountData = $mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT id_users, name, email, roles, active FROM users WHERE roles>='2' ORDER BY id_users ASC LIMIT $limit OFFSET $offset";
            $resulData = $mysqli->query($sqlSearch);
        }

        $response = [];
        if ($resulData->num_rows == 0) {
            $data['rnum'] = "#";
            $data['name'] = "Data Kosong";
            $data['email'] = "Data Kosong";
            $data['roles'] = "Data Kosong";
            $data['active'] = "Data Kosong";
            $arr[] = $data;
        }


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
}
