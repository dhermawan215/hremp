<?php
require_once '../Database/Databases.php';
date_default_timezone_set('Asia/Jakarta');

class Login
{

    public function __construct()
    {
        return $this->db = new Databases();
    }

    public function register($request)
    {
        $name = $request['name'];
        $email = $request['email'];
        $password = $request['password'];

        unset($request['_token']);

        $roles = 1;
        $created_at = date("Y-m-d H:i:s");
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(name, email, roles, password, created_at) VALUES('$name', '$email', $roles, '$hash', '$created_at')";

        $mysqli = $this->db->connect();
        $hasil = $mysqli->query($sql);

        if ($hasil) {
            $_SESSION['usser'] = [
                'auth' => 'loged',
                'email' => $email,
                'roles' => $roles,
            ];
        }

        return $hasil;
    }

    public function uniqueEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email='$email'";

        $mysqli = $this->db->connect();
        $hasil = $mysqli->query($sql);

        return $hasil->num_rows;
    }
}
