<!DOCTYPE html>
<html lang="en">
<!-- <script type="text/javascript">
    window.print()
</script> -->
<style type="text/css">
    body {
        background-color: white;
    }

    @media print {
        body {
            zoom: 88%;
        }
    }

    /*@media print {
    body {transform: scale(.7);}
    table {page-break-inside: auto;}
    }*/
    #print {
        margin: auto;
        text-align: center;
        font-family: "Calibri", Courier, monospace;
        width: 90%;
        font-size: 14px;
    }

    #print .title {
        margin: 20px;
        text-align: right;
        font-family: "Calibri", Courier, monospace;
        font-size: 12px;
    }

    #print span {
        text-align: center;
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        font-size: 10px;
    }

    #print table {
        border-collapse: collapse;
        width: 100%;
        margin: 8px;

    }

    #print .table1 {
        border-collapse: collapse;
        width: 100%;
        text-align: center;
        margin: 8px;
    }

    #print hr {
        border: 3px double #000;
    }

    #print .ttd {
        float: right;
        width: 250px;
        background-position: center;
        background-size: contain;
    }

    #print table th {
        color: #000;
        font-family: Verdana, Geneva, sans-serif;
        font-size: 10px;
        padding-top: 8px;
        padding-bottom: 8px;
    }

    #print table td {
        color: #000;
        font-family: Verdana, Geneva, sans-serif;
        font-size: 9px;
        padding-top: 8px;
        padding-bottom: 8px;
    }

    #logo {
        width: 111px;
        height: 90px;
        padding-top: 10px;
        margin-left: 10px;
    }

    h2,
    h3 {
        margin: 0px 0px 0px 0px;
    }

    @page {
        size: 29.7cm 21cm;
        margin: 0mm 0mm 0mm 0mm;
        /* change the margins as you want them to be. */
    }
</style>
<?php
$route = 'allowance-create';
$title = 'Flexy App - Allowance Request Detail';
$appName = 'Flexy Allowance App';
include_once('../layout/header.php');
session_start();
include('../../app/config/is_session.php');


date_default_timezone_set('Asia/Jakarta');
if (isset($_GET['print'])) {
    $print = $_GET['print'];
}
?>
<div id="print">
    <div class="mt-5">
        <div class="d-flex justify-content-between">
            <div>
                <img src='../../public/img/zekindo companies 2.png' height="100" width="210">
            </div>
            <div>
                <p style="font-size:14px;">
                <h4>PT. POWERINDO KIMIA MINERAL</h4>
                <i>The Prominence Office Tower, 12th Floor, Suite E & H <br />
                    Jl. Jalur Sutera Barat Kav.15 <br />
                    Alam Sutera - Tangerang 15325 <br />
                    Phone: +62 21-8082-1302 Fax: +62 21-2977-9315</i></p>

            </div>
        </div>
    </div>
    <!-- Informasi Header -->
    <td>
        <h2 id="subject"></h2>
    </td>
    </br>
    <table>
        <div class="container">

            <div class="d-flex justify-content-between">
                <div>
                    <label style="font-size:16px;"><b>ID Allowance : <?php echo $print  ?></b></label>
                </div>
                <div>
                    <label style="font-size:16px; font-weight: 600" id="transaction-date"></label>
                </div>
                <div>
                    <label style="font-size:16px; font-weight: 600" id="requestor"></label>
                </div>
                <div>
                    <label style="font-size:16px; font-weight: 600" id="company_name"></label>
                </div>
                <div>
                    <label style="font-size:16px; font-weight: 600" id="cost_center"></label>
                </div>
                <div>
                    <label style="font-size:16px; font-weight: 600" id="period"></label>
                </div>
            </div>
        </div>
    </table>
    <!-- Informasi Header Selesai -->

    <!-- Detail Allowance -->
    <table border='2' width="100%" class="table">
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
    <!-- Detail Allowance Selesai -->
</div>
<?php include_once('../layout/js.php') ?>
<script>
    var noAllowance = "<?php echo $print ?>"
</script>
<script src="<?= $url . ('/public/flexy-allowance-user/print.min.js?q=') . time() ?>"></script>

</html>