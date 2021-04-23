<?php
session_start();
$title = "HomePage";
include('header.php');
include('navbar.php');
include('../config/dalpublic.php');

$page = 1;

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = "";
}

$no_of_records_per_page = 21;
$offset = ($page - 1) * $no_of_records_per_page;
$data = GetProjectPrev($no_of_records_per_page, $offset, $search);
$total_pages = $data[1];
?>
<link rel="stylesheet" href="../css/index.css">
<div class="container-fluid">
    <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between my-2">                 
                <div class="page-header">
                    <h1><?=$title?></h1>
                </div>
                    <form class="form-inline" action = "" method="get">
                        <input class="form-control mr-sm-2" type="text" name="search" value="<?=$search?>">
                        <button class="btn btn-primary my-2 my-sm-0" type="submit"><i class="fas fa-search"></i>Cerca</button>
                    </form>
                </div>
            </div>
        </div>
    <div class="row">
        <?=$data[0];?>
    </div>
    <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-around">
                    <nav>
                        <ul class="pagination">
<?php if ($search=="") {?>
                            <li class="page-item"><a class="page-link" href="?page=1">First</a></li>
                            <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>">Prev</a>
                            </li>
                            <li class="page-item <?php if($page >= $total_pages){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>">Next</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="?page=<?=$total_pages; ?>">Last</a></li>
<?php }else{ ?>
                            <li class="page-item"><a class="page-link" href="?page=1&search=<?=$search?>">First</a></li>
                            <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1)."&search=".$search; } ?>">Prev</a>
                            </li>
                            <li class="page-item <?php if($page >= $total_pages){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1)."&search=".$search; } ?>">Next</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="?page=<?=$total_pages;?>&search=<?=$search?>">Last</a></li>
<?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
</div>

<?php
include('footer.php');
?>