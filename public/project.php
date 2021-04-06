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
                    <div class="carousel slide" id="carousel-272855">
                        <ol class="carousel-indicators">
                            <li data-slide-to="0" data-target="#carousel-272855">
                            </li>
                            <li data-slide-to="1" data-target="#carousel-272855">
                            </li>
                            <li data-slide-to="2" data-target="#carousel-272855" class="active">
                            </li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item">
                                <img class="d-block w-100" alt="Carousel Bootstrap First" src="https://www.layoutit.com/img/sports-q-c-1600-500-1.jpg" />
                                <div class="carousel-caption">
                                    <h4>
                                        First Thumbnail label
                                    </h4>
                                    <p>
                                        Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                                    </p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" alt="Carousel Bootstrap Second" src="https://www.layoutit.com/img/sports-q-c-1600-500-2.jpg" />
                                <div class="carousel-caption">
                                    <h4>
                                        Second Thumbnail label
                                    </h4>
                                    <p>
                                        Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                                    </p>
                                </div>
                            </div>
                            <div class="carousel-item active">
                                <img class="d-block w-100" alt="Carousel Bootstrap Third" src="https://www.layoutit.com/img/sports-q-c-1600-500-3.jpg" />
                                <div class="carousel-caption">
                                    <h4>
                                        Third Thumbnail label
                                    </h4>
                                    <p>
                                        Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                                    </p>
                                </div>
                            </div>
                        </div> <a class="carousel-control-prev" href="#carousel-272855" data-slide="prev"><span class="carousel-control-prev-icon"></span> <span class="sr-only">Previous</span></a> <a class="carousel-control-next" href="#carousel-272855" data-slide="next"><span class="carousel-control-next-icon"></span> <span class="sr-only">Next</span></a>
                    </div>
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