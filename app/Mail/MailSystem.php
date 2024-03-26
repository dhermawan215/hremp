<?php

namespace App\Mail;

require '../../vendor/autoload.php';
require '../Mail/ConfigMail.php';
require '../Controller/UriController.php';

use App\Controller\UriController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailSystem extends ConfigMail
{
    public $mail;
    public $homeUrl;

    public function __construct()
    {
        $this->mail = new PHPMailer;
        $this->homeUrl = new UriController;
    }

    public function sendEmail($data)
    {
        $response = [];
        try {
            $this->mail->send();
            $response['status'] = true;
            $response['message'] = 'email has been sent';

            return $response;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = 'Message could not be sent. Mailer Error: ' . $this->mail->ErrorInfo;
        }
    }

    public function prepareMail()
    {
        //Server settings
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = ConfigMail::$host;                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = ConfigMail::$userName;                     //SMTP username
        $this->mail->Password   = ConfigMail::$password;                               //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->mail->Port       = ConfigMail::$port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    }

    public function recipientMail($email = [])
    {
        $emailAddress = $email['address'];
        $emailName = $email['username'];
        //Recipients
        $this->mail->setFrom('flexy.app@powerchemicals.co.id', 'Flexy App Mail System');
        $this->mail->addAddress($emailAddress, $emailName);     //Add a recipient
        // $this->mail->addAddress('ellen@example.com');               //Name is optional
        // $this->mail->addReplyTo('info@example.com', 'Information');
        // $this->mail->addCC('cc@example.com');
        // $this->mail->addBCC('bcc@example.com');
    }

    public function contentMail($content = [])
    {
        //Content
        // $urlPath = $this->url->homeurl();
        // $imagePath = $urlPath . '/public/img/logo-zekindo-comp.png';
        $this->mail->isHTML(true);                                  //Set email format to HTML
        $this->mail->Subject = 'Allowance Request';
        $this->mail->Body    = '
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
                                    <img src="" height="50px">
                                    <h5>Flexy Allowance App</h5></div>
                                    <hr>
                                    <p>Dear Salsa/Carissa/Bu Yana</p>
                                    <p>Dicky Hermawan, submitted an allowance request with the following details:</p>
                                    <ul style="list-style-type: none; margin-left:-25px">
                                        <li>No Allowance:</li>
                                        <li>Subject:</li>
                                        <li>Total:</li>
                                        <li>Date:</li>
                                    </ul>
                                    <div style="display:flex; justify-content:flex-start; margin-bottom:10px">
                                        <a href="" style="margin-right:10px" class="btn btn-primary">Approve</a>
                                        <a href="" style="margin-right:10px" class="btn btn-danger">Rejected</a>
                                        <a href="" class="btn btn-warning">Revision</a>
                                    </div>
                                    
                                    <p>For allowance details can be seen in the link below:</p>
                                    <a href="#">View thi request in HR Integrated system - flexy allowance app</a>
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
    }

    public function attachmentMail($path)
    {
        //Attachment
        $this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    }
}
