<?php

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

class DashboardController
{
    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }
}
