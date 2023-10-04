<?php

namespace App\Controller;

use App\Database\Databases;

require_once '../Database/Databases.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

class Login
{
    private $db;
    public function __construct()
    {
        return $this->db = new Databases;
    }

    public function register($request)
    {
        $name = $request['name'];
        $email = $request['email'];
        $password = $request['password'];

        unset($request['_token']);

        $roles = $request['roles'];
        $created_at = date("Y-m-d H:i:s");
        $active = 'true';
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(name, email, roles, password, active, created_at) VALUES('$name', '$email', $roles, '$hash','$active', '$created_at')";

        $mysqli = $this->db->connect();
        $hasil = $mysqli->query($sql);

        return $hasil;
    }

    public function uniqueEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email='$email'";

        $mysqli = $this->db->connect();
        $hasil = $mysqli->query($sql);

        return $hasil->num_rows;
    }

    public function login($request)
    {
        $email = $request['email'];
        $pwd = $request['password'];
        $sql  = "SELECT * FROM users WHERE email='$email' AND active='true' LIMIT 1";
        $mysqli = $this->db->connect();
        $hasil = $mysqli->query($sql);

        $data = [];
        if ($hasil->num_rows == 1) {
            $dataSql = $hasil->fetch_object();
            $pwsd = $dataSql->password;

            $pwdsuccess = $this->passwordVerify($pwsd, $pwd);
            if ($pwdsuccess != true) {
                $data['success'] = false;
                $data['data'] = 'Terjadi masalah saat login. Periksa email dan sandi Anda!';
                return $data;
            }

            session_start();
            $_SESSION['user'] = [
                'auth' => 'loged',
                'email' => $dataSql->email,
                'roles' => $dataSql->roles,
                'name' => $dataSql->name,
            ];

            $data['success'] = true;
            $data['data'] = 'Authenticated';
            return $data;
        } else {
            $data['success'] = false;
            $data['data'] = 'Terjadi masalah saat login. Periksa email dan sandi Anda atau hubungi administrator!';
            return $data;
        }
    }

    public function passwordVerify($pwsd, $pwd)
    {
        if (password_verify($pwd, $pwsd)) {
            return true;
        } else {
            return false;
        }
    }
}
