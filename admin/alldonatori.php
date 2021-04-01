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


<?php
    include 'footer.php';
?>
    </body>
<?php