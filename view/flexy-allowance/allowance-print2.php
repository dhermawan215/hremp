<!DOCTYPE html>
<html lang="en">


<head>
    <?php
    $route = 'allowance-create';
    $title = 'Flexy App - Allowance Print Report';
    $appName = 'Flexy Allowance App';
    include_once('../layout/header.php');
    session_start();
    include('../../app/config/is_session.php');


    date_default_timezone_set('Asia/Jakarta');
    if (isset($_GET['print'])) {
        $print = $_GET['print'];
    }
    ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        @media print {
            @page {
                size: 29.7cm 21cm;
                margin: 0mm 0mm 0mm 0mm;
                /* change the margins as you want them to be. */
            }
        }

        ul {
            padding: 0;
            margin: 0 0 1rem 0;
            list-style: none;
        }

        body {
            font-family: "Inter", sans-serif;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        table th,
        table td {
            border: 1px solid silver;
        }

        table th,
        table td {
            text-align: right;
            padding: 8px;
        }

        h1,
        h4,
        p {
            margin: 0;
        }

        .container {
            padding: 20px 0;
            width: 100%;
            max-width: 90%;
            margin: 0 auto;
        }

        .inv-title {
            padding: 10px;
            border: 1px solid silver;
            text-align: center;
            margin-bottom: 30px;
        }

        /* CSS untuk judul invoice */
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* CSS untuk gambar di pojok kanan */
        .invoice-image {
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            /* Sesuaikan lebar gambar sesuai kebutuhan */
            height: auto;
        }

        /* CSS untuk mengatur judul invoice dan gambar dalam satu container */
        .invoice-header {
            position: relative;
            margin-bottom: 80px;
        }

        /* CSS untuk judul invoice yang diatur di sebelah kiri */
        .title-left {
            float: left;
        }

        .inv-logo {
            width: 150px;
            display: block;
            margin: 0 auto;
            margin-bottom: 40px;
        }

        /* header */
        .inv-header {
            display: flex;
            margin-bottom: 20px;
        }

        .inv-header> :nth-child(1) {
            flex: 2;
        }

        .inv-header> :nth-child(2) {
            flex: 1;
        }

        .inv-header h2 {
            font-size: 20px;
            margin: 0 0 0.3rem 0;
        }

        .inv-header ul li {
            font-size: 15px;
            padding: 3px 0;
        }

        /* body */
        .inv-body table th,
        .inv-body table td {
            text-align: left;
        }

        .inv-body {
            margin-bottom: 30px;
        }

        /* footer */
        .inv-footer {
            display: flex;
            flex-direction: row;
        }

        .inv-footer> :nth-child(1) {
            flex: 2;
        }

        .inv-footer> :nth-child(2) {
            flex: 1;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="invoice-header">
            <div class="title-left">
                <h1 class="invoice-title">Allowance ID: <?= $print ?></h1>
            </div>
            <img src="<?= $url ?>/public/img/logo-zekindo-comp.png" alt="Gambar Invoice" class="invoice-image">
        </div>
        <hr style="border: 1px solid #000;">
        <div class="inv-header">
            <div>
                <h2 id="subject"></h2>
                <ul>
                    <li id="requestor"></li>
                    <li id="company_name">/li>
                    <li id="cost_center"></li>
                </ul>
            </div>
            <div>
                <table>
                    <tr>
                        <th>Claimed Date</th>
                        <td id="transaction-date"></td>
                    </tr>
                    <tr>
                        <th>Period</th>
                        <td id="period"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="inv-body">
            <table>
                <thead>
                    <tr>
                        <th style="padding-left: 2px; padding-right: 2px;">No.</th>
                        <th style="padding-left: 2px; padding-right: 2px;">Activity</th>
                        <th style="padding-left: 2px; padding-right: 2px;">Detail</th>
                        <th style="padding-left: 2px; padding-right: 2px;">Description</th>
                        <th style="padding-left: 2px; padding-right: 2px;">Dependents</th>
                        <th style="padding-left: 2px; padding-right: 2px;">Insured</th>
                        <th style="padding-left: 2px; padding-right: 2px;">Total Amount</th>
                        <th style="padding-left: 2px; padding-right: 2px;">Claimed Amount</th>
                        <th style="padding-left: 2px; padding-right: 2px;">Activity Date</th>
                    </tr>
                </thead>
                <tbody id="detailPrint">

                </tbody>
            </table>
        </div>
        <div class="inv-footer">
            <div><!-- required --></div>
            <div>
                <table>
                    <tr>
                        <th>Total Claimed Amount</th>
                        <td id="total_claim_amount"></td>
                    </tr>
                    <tr>
                        <th>Sales tax</th>
                        <td>200</td>
                    </tr>
                    <tr>
                        <th>Grand total</th>
                        <td>1200</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php include_once('../layout/js.php') ?>
    <script>
        var noAllowance = "<?php echo $print ?>"
    </script>
    <script src="<?= $url . ('/public/flexy-allowance-user/print.min.js?q=') . time() ?>"></script>
</body>

</html>