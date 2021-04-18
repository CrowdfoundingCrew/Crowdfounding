<?php
session_start();
$title = "HomePage";
include('header.php');
include('navbar.php');
include('../config/dalpublic.php');
?>
<link rel="stylesheet" href="../css/index.css">
<div class="container-fluid">
    <div class="row">
        <?php
        echo GetProjectPrev(); ?>
    </div>
</div>

<?php
include('footer.php');
?>