<?php

namespace App\Controller;

require_once '../../app/Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

use App\Database\Databases;
use App\Controller\UriController;

class DocumentController
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


    public function getDataDocuments($request)
    {
        $url = $this->home->homeurl();

        $users2 = (object) $this->user;

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];

        $sqlcountTotalData = "SELECT COUNT(id) AS counts FROM documents";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sqlcountTotalData);
        $fetchData = $resultQuery->fetch_object();

        $totalData = $fetchData->counts;
        $totalFiltered = $fetchData->counts;

        $i = $offset + 1;

        $data = [];

        if ($search != null) {
            $sqlSearch = "SELECT * FROM documents WHERE file_name LIKE '%$search%' ORDER BY id ASC LIMIT $limit OFFSET $offset ";
            $resulData = $mysqli->query($sqlSearch);

            $sqlSearchCount = "SELECT COUNT(id) AS counts FROM documents WHERE file_name LIKE '%$search%' ORDER BY id ASC LIMIT $limit OFFSET $offset";
            $resulCountData = $mysqli->query($sqlSearchCount);
            $resulCountsData = $resulCountData->fetch_object();

            $totalFiltered = $resulCountsData->counts;
        } else {
            $sqlSearch = "SELECT * FROM documents ORDER BY id ASC LIMIT $limit OFFSET $offset";
            $resulData = $mysqli->query($sqlSearch);
        }

        $response = [];
        if ($resulData->num_rows == 0) {
            $data['rnum'] = "#";
            $data['name'] = "Data Kosong";
            $data['upload_time'] = "Data Kosong";
            $data['action'] = "Data Kosong";
            $arr[] = $data;
        }


        while ($row = $resulData->fetch_object()) {
            $id = base64_encode($row->id);
            $data['rnum'] = $i;
            $data['name'] = $row->file_name;
            $data['upload_time'] = \date('d-m-Y H:i:s', \strtotime($row->upload_time));
            if ($users2->roles == '2' || $users2->roles == '1') {
                $deleteBtn = "<button id='btnDelete' class='btndel ms-2 text-danger border-0' data-id='$row->id'><i class='bi bi-trash'></i></button>";
            } else {
                $deleteBtn = '';
            }
            $data['path'] = $url . '/public/documents/file/' . $row->path;
            $data['action'] = "<div class='d-flex'><button id='btnShowDocs' class='btn btn-outline-primary align-middle' data-bs-toggle='modal' data-bs-target='#modalShowDocs' title='show'><i class='bi bi-eye'></i></button>$deleteBtn</div>";
            $arr[] = $data;
            $i++;
        }

        $response['draw'] = $draw;
        $response['recordsTotal'] = $totalData;
        $response['recordsFiltered'] = $totalFiltered;
        $response['data'] = $arr;

        return $response;
    }

    public function upload($request)
    {
        $path = $request['path'];
        $name = $request['file_name'];
        $created_at = date("Y-m-d H:i:s");
        $upload_time = date("Y-m-d H:i:s");
        // move document to folder public
        \move_uploaded_file($request['temp'], '../../public/documents/file/' . $path);

        // insert data ke db
        $sqlInput = "INSERT INTO documents(file_name,path,upload_time,created_at) VALUES('$name', '$path', '$upload_time', '$created_at')";
        $mysqli = $this->db->connect();
        $resulSave = $mysqli->query($sqlInput);
        return $resulSave;
    }

    public function destroy($id)
    {
        // select data to unlink dokumen in server
        $sqlData = "SELECT * FROM documents WHERE id=$id";
        $mysqli = $this->db->connect();
        $resultData = $mysqli->query($sqlData);
        $fetchResultData = $resultData->fetch_object();

        // delete dokumen
        $unlinkData = \unlink('../../public/documents/file/' . $fetchResultData->path);

        if (!$unlinkData) {
            return \false;
        }

        // delete data
        $sqlDelete = "DELETE FROM documents WHERE id=$id";
        $mysqli = $this->db->connect();
        $resultDelete = $mysqli->query($sqlDelete);
        return $resultDelete;
    }
}
