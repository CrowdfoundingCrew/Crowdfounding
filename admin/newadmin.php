<?php
include('checksession.php');
$title = "Crea un nuovo amministratore";
include('header.php');
include('navbar.php');
if (isset($_POST["Register"])) {
    require('mysql.php');
    if ($_POST["password"] === $_POST["cpassword"] && $_POST["password"] != "" && $_POST["username"] != "" && $_POST["nome"] != "" && $_POST["cognome"] != "" && $_POST["email"] != "") {
        NewAdmin($_POST["nome"], $_POST["cognome"], $_POST["username"], $_POST["email"], $_POST["password"]);
        header("Location: ../public/");
    } else{
        unset($_POST["Register"]);
        header("Location: newadmin.php");
    }
}
?>

<body>
    <div class="container-fluid align-middle mt-5">
        <div class="row centered-form d-flex justify-content-center flex-wrap">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title d-flex justify-content-center"><?= $title ?></h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="POST" action="">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="nome" id="nome" class="form-control input-sm" placeholder="Nome">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="cognome" id="cognome" class="form-control input-sm" placeholder="Cognome">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="username" id="username" class="form-control input-sm" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email">
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="cpassword" id="cpassword" class="form-control input-sm" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>
                        <input type="submit" name="Register" value="Registra" class="btn btn-info btn-block">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../js/common.js"></script>