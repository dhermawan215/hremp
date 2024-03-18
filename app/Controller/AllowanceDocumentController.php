<?php

namespace App\Controller;

require_once '../../app/Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

use App\Database\Databases;

class AllowanceDocumentController
{
    public $user;
    private $db;
    public $homeUrl;


    public function __construct()
    {
        session_start();
        $this->db = new Databases();
        $this->user = $_SESSION['user'];
        $this->homeUrl = new UriController;
    }

    //untuk dataTable
    public function getDataDocuments($request)
    {

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];
        $allowance_id = $request['allowance'];

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
            $data['upload_time'] = \date('d-m-Y H:i:s', \strtotime($row->upload_at));
            $data['action'] = '<button type="button" class="btn btn-danger btn-sm btn-delete-attachment" data-attachment="' . $id . '">Delete</button>';
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
        $temp = $request['temp'];
        $allowance_id = $request['allowance'];
        $upload_time = date("Y-m-d H:i:s");
        // move document to folder public
        \move_uploaded_file($temp, '../../public/allowance/file/' . $path);

        // insert data ke db
        $sqlInput = "INSERT INTO allowance_file (allowance_id,document_name, path, uploaded_at) VALUES('$allowance_id','$name', '$path', '$upload_time')";
        $mysqli = $this->db->connect();
        $resulSave = $mysqli->query($sqlInput);
        return $resulSave;
    }

    public function destroy($id)
    {
        // iini belum di kerjakan, masih ngawur
        // select data to unlink dokumen in server
        $sqlData = "SELECT * FROM documents WHERE id=$id";
        $mysqli = $this->db->connect();
        $resultData = $mysqli->query($sqlData);
        $fetchResultData = $resultData->fetch_object();

        // delete dokumen
        $unlinkData = \unlink('../../public/allowance/file/' . $fetchResultData->path);

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
