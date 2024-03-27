<?php

use App\Controller\UriController;
use App\Database\Databases;
use Carbon\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../Controller/UriController.php';
require_once '../Database/Databases.php';
require_once '../../vendor/autoload.php';

date_default_timezone_set('Asia/Jakarta');

// variable
$emailHost = 'mail.powerchemicals.co.id';
$userName = 'flexy.app@powerchemicals.co.id';
$emailPwd = 'AllowanceApp1234!';
$port = 465;
$urlRoot = new UriController;
$db = new Databases;
$url = $urlRoot->homeurl();
$con = $db->connect();

if (isset($_GET['token']) && $_GET['action'] == 'approve') {
    //    ambil nomer allowance dari token
    $token = $_GET['token'];
    $checkBy = $_GET['check'];
    $partsToken = explode(',', $token);

    // Mengambil ID dari bagian pertama array hasil pemisahan
    $nomerAllowance = $partsToken[0];
    // cek apabila sudah approve start
    $sqlCekApprove = "SELECT hr_approve FROM allowance WHERE nomer='$nomerAllowance'";
    $queryCekApprove = $con->query($sqlCekApprove);
    $dataApprove = $queryCekApprove->fetch_object();
    if ($dataApprove->hr_approve >= '2') {
        echo "<script>if(confirm('Action denided!')) document.location.href='$url';</script>";
        exit;
    }
    // cek apabila sudah approve end
    $updateTimestamp = Carbon::now();
    // update data allowance jika hr approve
    $sql = "UPDATE allowance SET hr_approve=2, hr_notes=null, hr_check_by='$checkBy', hr_check_at='$updateTimestamp', manager_approve=1, updated_at='$updateTimestamp' WHERE nomer='$nomerAllowance'";
    $query = $con->query($sql);
    // ambil data allowance
    $sql2 = "SELECT id_allowance, nomer, transaction_date, nama AS subject, period, total, token,hr_check_by,hr_check_at, users.name, company.company_name, cost_center.cost_center_name, department.dept_name 
    FROM allowance LEFT JOIN users ON allowance.users_id = users.id_users
    LEFT JOIN company ON allowance.company_id = company.IdCompany
    LEFT JOIN cost_center ON allowance.cost_center_id = cost_center.id_cost_center
    LEFT JOIN department ON allowance.department_id = department.id_dept
    WHERE allowance.nomer = '$nomerAllowance';";
    $queryForEmailContent = $con->query($sql2);
    $data = $queryForEmailContent->fetch_object();

    $mail = new PHPMailer(true);
    $name = 'Yana Marlianty';
    $hrAdminEmail = 'manager.test@powerchemicals.co.id';

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $emailHost;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $userName;                     //SMTP username
        $mail->Password   = $emailPwd;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = $port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('flexy.app@powerchemicals.co.id', 'Flexy App Mail System');
        $mail->addAddress($hrAdminEmail);      //Add a recipient

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        $urlPath = $url;
        $imagePath = $urlPath . '/public/img/logo-zekindo-comp.png';
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Flexy App - Allowance No: ' . $data->nomer . ' is appoved by HR';
        $mail->Body    = '
            <html lang="en">
                <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <title>Simple Transactional Email</title>
                    <style media="all" type="text/css">
                        /* -------------------------------------
                        GLOBAL RESETS
                        ------------------------------------- */
                    
                        body {
                        font-family: Helvetica, sans-serif;
                        -webkit-font-smoothing: antialiased;
                        font-size: 16px;
                        line-height: 1.3;
                        -ms-text-size-adjust: 100%;
                        -webkit-text-size-adjust: 100%;
                        }
                        
                        table {
                        border-collapse: separate;
                        mso-table-lspace: 0pt;
                        mso-table-rspace: 0pt;
                        width: 100%;
                        }
                        
                        table td {
                        font-family: Helvetica, sans-serif;
                        font-size: 16px;
                        vertical-align: top;
                        }
                                /* -------------------------------------
                                BODY & CONTAINER
                            ------------------------------------- */
                        
                        body {
                        background-color: #f4f5f6;
                        margin: 0;
                        padding: 0;
                        }
                    
                        .body {
                        background-color: #f4f5f6;
                        width: 100%;
                        }
                        
                        .container {
                        margin: 0 auto !important;
                        max-width: 600px;
                        padding: 0;
                        padding-top: 24px;
                        width: 600px;
                        }
                        
                        .content {
                        box-sizing: border-box;
                        display: block;
                        margin: 0 auto;
                        max-width: 600px;
                        padding: 0;
                        }
                                /* -------------------------------------
                                HEADER, FOOTER, MAIN
                            ------------------------------------- */
                        
                        .main {
                        background: #ffffff;
                        border: 1px solid #eaebed;
                        border-radius: 16px;
                        width: 100%;
                        }
                        
                        .wrapper {
                        box-sizing: border-box;
                        padding: 24px;
                        }
                        
                        .footer {
                        clear: both;
                        padding-top: 24px;
                        text-align: center;
                        width: 100%;
                        }
                        
                        .footer td,
                        .footer p,
                        .footer span,
                        .footer a {
                        color: #9a9ea6;
                        font-size: 16px;
                        text-align: center;
                        }
                                /* -------------------------------------
                                TYPOGRAPHY
                            ------------------------------------- */
                        
                        p {
                        font-family: Helvetica, sans-serif;
                        font-size: 16px;
                        font-weight: normal;
                        margin: 0;
                        margin-bottom: 16px;
                        }
                        
                        a {
                        color: #0867ec;
                        text-decoration: underline;
                        }
                                /* -------------------------------------
                                BUTTONS
                            ------------------------------------- */
                        /* Gaya dasar untuk tombol */
                        .btn {
                            display: inline-block;
                            font-weight: 400;
                            color: #212529;
                            text-align: center;
                            vertical-align: middle;
                            -webkit-user-select: none;
                            -moz-user-select: none;
                            -ms-user-select: none;
                            user-select: none;
                            background-color: transparent;
                            border: 1px solid transparent;
                            padding: 0.375rem 0.75rem;
                            font-size: 1rem;
                            line-height: 1.5;
                            border-radius: 0.25rem;
                            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                        }

                        /* Gaya tambahan untuk tombol dengan variasi warna */
                        .btn-primary {
                            color: #fff;
                            background-color: #007bff;
                            border-color: #007bff;
                            text-decoration:none;
                        }
                        .btn-primary:hover {
                            color: #fff;
                            background-color: #0056b3;
                            border-color: #0056b3;
                        }
                        .btn-primary:focus, .btn-primary.focus {
                            color: #fff;
                            background-color: #0056b3;
                            border-color: #0056b3;
                            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
                        }
                        .btn-primary.disabled, .btn-primary:disabled {
                            color: #fff;
                            background-color: #007bff;
                            border-color: #007bff;
                        }
                        
                        .btn-danger {
                            color: #fff;
                            background-color: #d61a0d;
                            border-color: #911209;
                            text-decoration:none;
                        }
                        .btn-danger:hover {
                            color: #fff;
                            background-color: #911209;
                            border-color: #d61a0d;
                        }
                        .btn-danger:focus, .btn-danger.focus {
                            color: #fff;
                            background-color: #911209;
                            border-color: #d61a0d;
                            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
                        }
                        .btn-danger.disabled, .btn-danger:disabled {
                            color: #fff;
                            background-color: #d61a0d;
                            border-color: #911209;
                        }
                        .btn-warning {
                            color: #fff;
                            background-color: #cc9808;
                            border-color: #a67b05;
                            text-decoration:none;
                        }
                        .btn-warning:hover {
                            color: #fff;
                            background-color: #a67b05;
                            border-color: #cc9808;
                        }
                        .btn-warning:focus, .btn-warning.focus {
                            color: #fff;
                            background-color: #a67b05;
                            border-color: #cc9808;
                            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
                        }
                        .btn-warning.disabled, .btn-warning:disabled {
                            color: #fff;
                            background-color: #a67b05;
                            border-color: #cc9808;
                        }

                        /* Gaya tambahan untuk tombol dengan variasi ukuran */
                        .btn-sm {
                            padding: 0.25rem 0.5rem;
                            font-size: 0.875rem;
                            line-height: 1.5;
                            border-radius: 0.2rem;
                        }
                        .btn-lg {
                            padding: 0.5rem 1rem;
                            font-size: 1.25rem;
                            line-height: 1.5;
                            border-radius: 0.3rem;
                        }
                        
                        @media all {
                        
                        }
                            
                            /* -------------------------------------
                            OTHER STYLES THAT MIGHT BE USEFUL
                        ------------------------------------- */
                        
                        .last {
                        margin-bottom: 0;
                        }
                        
                        .first {
                        margin-top: 0;
                        }
                        
                        .align-center {
                        text-align: center;
                        }
                        
                        .align-right {
                        text-align: right;
                        }
                        
                        .align-left {
                        text-align: left;
                        }
                        
                        .text-link {
                        color: #0867ec !important;
                        text-decoration: underline !important;
                        }
                        
                        .clear {
                        clear: both;
                        }
                        
                        .mt0 {
                        margin-top: 0;
                        }
                        
                        .mb0 {
                        margin-bottom: 0;
                        }
                        
                        .preheader {
                        color: transparent;
                        display: none;
                        height: 0;
                        max-height: 0;
                        max-width: 0;
                        opacity: 0;
                        overflow: hidden;
                        mso-hide: all;
                        visibility: hidden;
                        width: 0;
                        }
                        
                        .powered-by a {
                        text-decoration: none;
                        }
                        
                        /* -------------------------------------
                        RESPONSIVE AND MOBILE FRIENDLY STYLES
                        ------------------------------------- */
                            
                        @media only screen and (max-width: 640px) {
                        .main p,
                        .main td,
                        .main span {
                            font-size: 16px !important;
                        }
                        .wrapper {
                            padding: 8px !important;
                        }
                        .content {
                            padding: 0 !important;
                        }
                        .container {
                            padding: 0 !important;
                            padding-top: 8px !important;
                            width: 100% !important;
                        }
                        .main {
                            border-left-width: 0 !important;
                            border-radius: 0 !important;
                            border-right-width: 0 !important;
                        }
                        
                        
                        }
                        /* -------------------------------------
                        PRESERVE THESE STYLES IN THE HEAD
                        ------------------------------------- */
                        
                        @media all {
                            .ExternalClass {
                                width: 100%;
                            }
                            .ExternalClass,
                            .ExternalClass p,
                            .ExternalClass span,
                            .ExternalClass font,
                            .ExternalClass td,
                            .ExternalClass div {
                                line-height: 100%;
                            }
                            .apple-link a {
                                color: inherit !important;
                                font-family: inherit !important;
                                font-size: inherit !important;
                                font-weight: inherit !important;
                                line-height: inherit !important;
                                text-decoration: none !important;
                            }
                            #MessageViewBody a {
                                color: inherit;
                                text-decoration: none;
                                font-size: inherit;
                                font-family: inherit;
                                font-weight: inherit;
                                line-height: inherit;
                            }
                        }
                    </style>
                </head>
                <body>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
                    
                    <tr>
                        <td>&nbsp;</td>
                        <td class="container">
                            <div class="content">

                                <!-- START CENTERED WHITE CONTAINER -->
                                <span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="main">

                                <!-- START MAIN CONTENT AREA -->
                                <tr>
                                    
                                    <td class="wrapper">
                                    <div style="display:flex; justify-content: space-between;">
                                    <img src="' . $imagePath . '" height="50px">
                                    <h5>Flexy Allowance App</h5></div>
                                    <hr>
                                    <p>Dear ' . $name . '</p>
                                    <p>' . $data->name . ', submitted an allowance request it with the following details:</p>
                                    <ul style="list-style-type: none; margin-left:-25px">
                                        <li><b>Status: Approve/has been chek by HR Admin(' . $data->hr_check_by . ')</b></li>
                                        <li>Allowance ID: ' . $data->nomer . '</li>
                                        <li>Subject: ' . $data->subject . '</li>
                                        <li>Total: Rp. ' . \number_format($data->total, 0, ',', '.') . '</li>
                                        <li>Date: ' . $data->transaction_date . '</li>
                                        <li>Company: ' . $data->company_name . '</li>
                                        <li>Cost Center & Department: ' . $data->cost_center_name . '-' . $data->dept_name . '</li>
                                        <li>Period: ' . $data->period . '</li>
                                    </ul>
                                    <div style="display:flex; justify-content:flex-start; margin-bottom:10px">
                                        <a href="' . $url . '/app/callback/dir-approve-callback.php?token=' . $data->token . '&action=approve&check=' . $name . '" style="margin-right:10px" class="btn btn-primary">Approve</a>
                                        <a href="' . $url . '/app/callback/dir-reject-callback.php?token=' . $data->token . '&action=reject&check=' . $name . '" style="margin-right:10px" class="btn btn-danger">Rejected</a>
                                        <a href="' . $url . '/app/callback/dir-revision-callback.php?token=' . $data->token . '&action=revision&check=' . $name . '" class="btn btn-warning">Revision</a>
                                    </div>
                                    <ul style="list-style-type: none; margin-left:-25px">
                                    <li>Aproval Log: </li>
                                    <li>HR: ' . $data->hr_check_by . ' - ' . $data->hr_check_at . '</li>
                                </ul>
                                    
                                    <p>For allowance details can be seen in the link below:</p>
                                    <a href="' . $url . '/view/sign/dir-sign.php?token=' . $data->token . '">View this request in HR Integrated system - flexy allowance app</a>
                                <p style="margin-top:15px"><strong>Cheers!</strong></p>
                                <p>The HR Team</p>
                                </tr>
                                </table>
                                <!-- START FOOTER -->
                                <div class="footer">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                    <td class="content-block">
                                        <span class="apple-link">HR Integrated System &copy; 2024</span>
                                    
                                    </td>
                                    </tr>
                                    <tr>
                                    <td class="content-block powered-by">
                                        Powered by IT Zekindo Companies
                                    </td>
                                    </tr>
                                </table>
                                </div>                        
                            </div>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    </table>
                </body>
             </html>
        ';

        $mail->send();
        echo "<script>if(confirm('Allowance Approved')) document.location.href='$url';</script>";
    } catch (Exception $e) {
        echo "<script>if(confirm('Message could not be sent.')) document.location.href='$url';</script>";
    }
}
