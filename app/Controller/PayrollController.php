<?php

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';

class PayrollController
{
    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }

    public function store($request)
    {
        $emp_id = $request['emp_id'];
        $account = $request['account'];
        $payroll_name = $request['payroll_name'];

        $sql = "INSERT INTO payroll(emp_id,account,payroll_name) VALUES($emp_id, '$account', '$payroll_name')";
        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
