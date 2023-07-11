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

    public function show($id)
    {
        $sql = "SELECT id_payrol, emp_id, id_employee,
        nama, account, payroll_name FROM payroll JOIN employee 
        ON payroll.emp_id=employee.id_employee WHERE id_employee=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);


        if ($resultQuery->num_rows == 0) {
            $data['data_index'] = null;
            $data['nama'] = null;
            $data['account'] = null;
            $data['payroll_name'] = null;

            return $data;
        } else {
            $fetchQuery = $resultQuery->fetch_object();

            $data['data_index'] = $fetchQuery->id_payrol;
            $data['nama'] = $fetchQuery->nama;
            $data['account'] = $fetchQuery->account;
            $data['payroll_name'] = $fetchQuery->payroll_name;

            return $data;
        }
    }

    public function update($request)
    {
        $id = $request['idData'];
        $emp_id = $request['emp_id'];
        $account = $request['account'];
        $payroll_name = $request['payroll_name'];

        $sql = "UPDATE payroll SET account='$account', payroll_name='$payroll_name'
        WHERE id_payrol=$id";

        $mysqli = $this->db->connect();
        $resultQuery = $mysqli->query($sql);

        return $resultQuery;
    }
}
