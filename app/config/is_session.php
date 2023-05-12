<?php
if (isset($_SESSION['user'])) {
} else {
    echo "<script>
    document.location.href='http://localhost:3000/login.php';
    </script>";
}
