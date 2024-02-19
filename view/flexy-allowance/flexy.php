<?php
session_start();
?>

<h1>hello <?php var_dump($_SESSION['user']) ?></h1>