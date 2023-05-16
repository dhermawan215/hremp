<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    session_destroy();

    echo "<script>
    document.location.href='http://localhost:3000/login.php';
    </script>";
} else {

    http_response_code(403);
}
