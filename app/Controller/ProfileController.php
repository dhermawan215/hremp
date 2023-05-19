<?php
require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

class ProfileController
{
    public function __construct()
    {
        $this->db = new Databases();
    }

    public function verifyOldPassword($request)
    {
        $email = $request['email'];
        $pwd = $request['old_password'];
        $sql  = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $mysqli = $this->db->connect();
        $hasil = $mysqli->query($sql);

        $dataSql = $hasil->fetch_object();
        $pwsd = $dataSql->password;

        $pwdsuccess = $this->passwordVerify($pwsd, $pwd);

        return $pwdsuccess;
    }

    public function passwordVerify($pwsd, $pwd)
    {
        if (password_verify($pwd, $pwsd)) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePassword($request)
    {
        $email = $request['email'];
        $newPassword = $request['new_password'];
        $confirmPassword = $request['new_password_confirm'];

        $hash = password_hash($newPassword, PASSWORD_DEFAULT);

        if ($newPassword != $confirmPassword) {
            $data[] = 'Password Baru Tidak Sama!';
            $response = ['success' => false, 'data' => $data];
            return $response;
        }

        $sql  = "UPDATE users SET password='$hash' WHERE email='$email'";
        $mysqli = $this->db->connect();
        $hasil = $mysqli->query($sql);

        if ($hasil == true) {
            $data[] = 'Password Updated!';
            $response = ['success' => true, 'data' => $data];
            return $response;
        } else {
            $data[] = 'Internal Server Error, Try Again';
            $response = ['success' => false, 'data' => $data];
            return $response;
        }
    }
}
