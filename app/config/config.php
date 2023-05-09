<?php

$conn = mysqli_connect('localhost', 'root', '', 'hrapp_karyawan');

$csrf_token = md5(uniqid(mt_rand(), true));
