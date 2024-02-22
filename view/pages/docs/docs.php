<!DOCTYPE html>
<html lang="en">
<?php
$route = 'doc';
include_once('../../layout/header.php');
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

                    <h1 class="h3 mb-3"><strong>Documents</strong> Dashboard</h1>

                    <div class="row">
                        <div class="card">
                            <div class="flex">
                                <button id="btnAddDocs" class="btn btn-success m-3 p-2" data-bs-toggle="modal" data-bs-target="#modalFileUpload">+ Upload File</button>
                            </div>
                            <div class="card-header">
                                <h5 class="h5 fw-bold">Documents Data</h5>
                            </div>
                            <div class="card-body">

                                <table id="tableDocs" class="table table-striped" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama Dokumen</th>
                                            <th scope="col">Waktu Upload</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once('../../layout/footer.php') ?>
        </div>
    </div>

    <!-- modal -->
    <!-- Modal -->
    <div class="modal fade" id="modalFileUpload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Upload File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" enctype="multipart/form-data" id="formUploadDoc">
                        <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                        <!-- <div class="mb-3">
                            <label for="fileName" class="form-label">File Name</label>
                            <input class="form-control" name="file_name" type="text" id="fileName">
                        </div> -->
                        <div class="mb-3">
                            <label for="fileUpload" class="form-label">Choose your file</label>
                            <input class="form-control" name="file_upload" type="file" id="fileUpload">
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal show pdf -->
    <div class="modal fade" id="modalShowDocs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Document Preview: <span id="docsName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="pdfContainer"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <p>Unable to display PDF file. <a id="downloadDocs">Download</a> instead.</p>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('../../layout/js.php') ?>
    <script src="<?= $url . ('/public/documents/js/docs.min.js?q=') . time() ?>"></script>
</body>

</html>