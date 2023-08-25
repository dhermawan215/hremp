<!DOCTYPE html>
<html lang="en">
<?php include_once('../../layout/header.php');
session_start();
include('../../../app/config/is_session.php');
date_default_timezone_set('Asia/Jakarta');

?>

<body>
    <div class="wrapper">
        <?php include('../../layout/sidebar.php'); ?>

        <div class="main">
            <?php include('../../layout/navbar.php'); ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"><strong>Employee</strong> Dashboard</h1>

                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Data Karyawan Aktif Akan Habis Kontrak</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mt-2">
                                    <div class="table-responsive">
                                        <p class="text-danger">Default data yang ditampilkan adalah bulan <?= date('M') . '-' . date('Y') ?></p>
                                        <table id="tableReminderContract" class="table table-striped" style="width:100%">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">NIP</th>
                                                    <th scope="col">Nama</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Akhir Kontrak</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <?php $data_index = 0; ?>
                                                <tr>
                                                    <td>
                                                        <label for="">Cari</label>
                                                        <input type="hidden" data-index="<?php echo $data_index;
                                                                                            $data_index++; ?>">
                                                    </td>
                                                    <td>
                                                        <label for="">Data Berdasarkan</label>
                                                        <input type="hidden" data-index="<?php echo $data_index;
                                                                                            $data_index++; ?>">
                                                    </td>
                                                    <td>
                                                        <label for="">Bulan dan Tahun:</label>
                                                        <input type="hidden" data-index="<?php echo $data_index;
                                                                                            $data_index++; ?>">
                                                    </td>
                                                    <td>
                                                        <select name="bulan_cari" id="bulanCari" class="form-control tfoot-search" data-index="<?php echo $data_index;
                                                                                                                                                $data_index++; ?>">
                                                            <option>-Pilih Bulan-</option>
                                                            <option value=" 01">Januari</option>
                                                            <option value="02">Februari</option>
                                                            <option value="03">Maret</option>
                                                            <option value="04">April</option>
                                                            <option value="05">Mei</option>
                                                            <option value="06">Juni</option>
                                                            <option value="07">Juli</option>
                                                            <option value="08">Agustus</option>
                                                            <option value="09">September</option>
                                                            <option value="10">Oktober</option>
                                                            <option value="11">November</option>
                                                            <option value="12">Desember</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="tahun_cari" id="tahunCari" class="form-control tfoot-search" data-index="<?php echo $data_index;
                                                                                                                                                $data_index++; ?>">
                                                            <option>-Pilih Tahun-</option>
                                                            <?php
                                                            for ($i = 2023; $i <= date('Y'); $i++) {
                                                                echo "<option value=$i>$i</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </main>
            <?php include_once('../../layout/footer.php') ?>
        </div>
    </div>

    <?php include_once('../../layout/js.php') ?>
    <script src="<?= $url . ('/public/employee/reminder-contract.min.js?q=') . time() ?>"></script>
</body>

</html>