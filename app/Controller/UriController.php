<?php

namespace App\Controller;

include_once '../protected.php';
class UriController
{
    public function homeurl()
    {
        $url = 'http://localhost:3000';
        return $url;
    }
}
