<!DOCTYPE html>
<html lang="en">
<?php
require '../Database/Databases.php';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Pegawai Resign - Pendidikan Karyawan.xls");

use App\Database\Databases;

$db = new Databases;
$sql = "SELECT nip, lokasi, nama, tgl_masuk, tgl_kartap, email_kantor,
pangkat, jabatan, bpjstk, bpjskes, status_name, company_name, dept_name,
pendidikan_terakhir, jurusan, asal_sekolah
FROM employee JOIN status_emp ON employee.status_emp=status_emp.id_status JOIN company 
ON employee.comp_id=company.IdCompany JOIN department ON employee.dept_id=department.id_dept JOIN education
ON employee.id_employee=education.emp_id WHERE employee.is_resigned=1";

$no = 1;
$db2 = $db->connect();
$resultQuery = $db2->query($sql);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pribadi Karyawan</title>
</head>

<body>
    <h1>Data Karyawan Resign (Data Pendidikan)</h1>
    <table>
        <thead>
            <tr>
                <th>
                    No
                </th>
                <th>
                    NIP Karyawan
                </th>
                <th>
                    Nama Karyawan
                </th>
                <th>
                    Lokasi Kerja
                </th>
                <th>
                    Tgl Masuk
                </th>
                <th>
                    Tgl Kartap
                </th>
                <th>
                    Emai Kantor
                </th>
                <th>
                    Pangkat
                </th>
                <th>
                    Jabatan
                </th>
                <th>
                    BPJSKES
                </th>
                <th>
                    BPJSTK
                </th>
                <th>
                    Status Karyawan
                </th>
                <th>
                    Perusahaan
                </th>
                <th>
                    Departemen
                </th>
                <th>
                    Pendidikan Terakhir
                </th>
                <th>
                    Jurusan
                </th>
                <th>
                    Asal Sekolah
                </th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_object($resultQuery)) : ?>
                <tr>
                    <td>
                        <?= $no++ ?>
                    </td>
                    <td>
                        <?= "'" . $row->nip ?>
                    </td>
                    <td>
                        <?= $row->nama ?>
                    </td>
                    <td>
                        <?= $row->lokasi ?>
                    </td>
                    <td>
                        <?= $row->tgl_masuk ?>
                    </td>
                    <td>
                        <?= $row->tgl_kartap ? $row->tgl_kartap : "Data Kosong"; ?>
                    </td>
                    <td>
                        <?= $row->email_kantor ?>
                    </td>
                    <td>
                        <?= $row->pangkat ?>
                    </td>
                    <td>
                        <?= $row->jabatan ?>
                    </td>
                    <td>
                        <?= "'" . $row->bpjskes ?>
                    </td>
                    <td>
                        <?= "'" . $row->bpjstk ?>
                    </td>
                    <td>
                        <?= $row->status_name ?>
                    </td>
                    <td>
                        <?= $row->company_name ?>
                    </td>
                    <td>
                        <?= $row->dept_name ?>
                    </td>
                    <td>
                        <?= $row->pendidikan_terakhir ?>
                    </td>
                    <td>
                        <?= $row->jurusan ?>
                    </td>
                    <td>
                        <?= $row->asal_sekolah ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>