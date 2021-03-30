<?php 
    //include 'checksession.php';
    include 'mysql.php';
    $title = 'Parte Admin Sgravata Pazza';
    $footer = 'Questo è un footer dinamico';
    $page = 1;
    include 'header.php';
    include 'navbar.php';
    
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
    } else {
        $search = "";
    }

    $no_of_records_per_page = 5;
    $offset = ($pageno - 1) * $no_of_records_per_page; 
    $data = Pagination($no_of_records_per_page, $offset, $search);
    $total_pages = $data[1]
?>
<body>
    <div class="container-xl">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between my-2">                 
                <div class="page-header">
                    <h1><?=$title?></h1>
                </div>
                    <form class="form-inline" action = "./allonlus.php" method="get">
                        <input class="form-control mr-sm-2" type="text" name="search" value="<?=$search?>">
                        <button class="btn btn-primary my-2 my-sm-0" type="submit"><span class="glyphicon glyphicon-search"></span>Search</button>
                    </form>
                </div>
            </div>
        </div>
<?=$data[0];?>
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-around">
                    <nav>
                        <ul class="pagination">
<?php if ($search=="") {?>
                            <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                            <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                            </li>
                            <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="?pageno=<?=$total_pages; ?>">Last</a></li>
<?php }else{ ?>
                            <li class="page-item"><a class="page-link" href="?pageno=1&search=<?=$search?>">First</a></li>
                            <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1)."&search=".$search; } ?>">Prev</a>
                            </li>
                            <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1)."&search=".$search; } ?>">Next</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="?pageno=<?=$total_pages;?>&search=<?=$search?>">Last</a></li>
<?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
<?php
    include 'footer.php';
?>
    </body>
<?php
//TODO
//TODO query