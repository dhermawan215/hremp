<?php

session_start();
session_destroy();

echo "<script>
document.location.href='http://localhost:3000/login.php';
</script>";
