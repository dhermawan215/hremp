<!DOCTYPE html>
<html lang="en">
<?php
$url = 'http://localhost:3000';
session_start();
include('../../../app/config/is_session.php');

if (isset($_GET['dataId']) && isset($_GET['dataStatus'])) {
    $id = base64_decode($_GET['dataId']);
    $status = base64_decode($_GET['dataStatus']);
    $id2 = $_GET['dataId'];
    $status2 = $_GET['dataStatus'];

    switch ($status) {
        case 2:
            echo "<script>
            document.location.href='$url/view/pages/employee/employee-kontrak.php?dataId=$id2&dataStatus=$status2';
            </script>";
            break;
        case 3:
            echo "<script>
            document.location.href='$url/view/pages/employee/employee-kontrak.php?dataId=$id2&dataStatus=$status2';
            </script>";
            break;
        case 4:
            echo "<script>
            document.location.href='$url/view/pages/employee/employee-kontrak.php?dataId=$id2&dataStatus=$status2';
            </script>";
            break;
        case 5:
            echo "<script>
            document.location.href='$url/view/pages/employee/employee-kontrak.php?dataId=$id2&dataStatus=$status2';
            </script>";
            break;

        default:
            # code...
            break;
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div>
            <div class="mb-4 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </svg>
            </div>
            <div class="text-center">
                <h1>Finish!</h1>
                <p>Penambahan Data Karyawan Sudah Selesai </p>
                <a href="/" class="btn btn-primary">Back Home</a>
            </div>
        </div>
</body>

</html>