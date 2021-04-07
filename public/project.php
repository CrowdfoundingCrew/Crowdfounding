<?php
require '../config/publicDal.php';
session_start();
$title = "HomePage";
include('header.php');
include('navbar.php');
$data = FindProject($_GET['Idprj']);
?>
<link rel="stylesheet" href="../css/project.css">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <img alt="Logo" src="<?= $data[10] ?>" width="350px" height="350px" />
        </div>
        <div class="col-md-8">
            <h3>
                <?= $data[0] ?>
            </h3>
            <p>
                <?= $data[1] ?>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <img alt="Logo" src=" <?= $data[8] ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">
                        <?= $data[0] ?>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="progress">
                        <div class="progress-bar w-75">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <?= $data[1] ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <?= $data[11] ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Product
                        </th>
                        <th>
                            Payment Taken
                        </th>
                        <th>
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            1
                        </td>
                        <td>
                            TB - Monthly
                        </td>
                        <td>
                            01/04/2012
                        </td>
                        <td>
                            Default
                        </td>
                    </tr>
                    <tr class="table-active">
                        <td>
                            1
                        </td>
                        <td>
                            TB - Monthly
                        </td>
                        <td>
                            01/04/2012
                        </td>
                        <td>
                            Approved
                        </td>
                    </tr>
                    <tr class="table-success">
                        <td>
                            2
                        </td>
                        <td>
                            TB - Monthly
                        </td>
                        <td>
                            02/04/2012
                        </td>
                        <td>
                            Declined
                        </td>
                    </tr>
                    <tr class="table-warning">
                        <td>
                            3
                        </td>
                        <td>
                            TB - Monthly
                        </td>
                        <td>
                            03/04/2012
                        </td>
                        <td>
                            Pending
                        </td>
                    </tr>
                    <tr class="table-danger">
                        <td>
                            4
                        </td>
                        <td>
                            TB - Monthly
                        </td>
                        <td>
                            04/04/2012
                        </td>
                        <td>
                            Call in to confirm
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>